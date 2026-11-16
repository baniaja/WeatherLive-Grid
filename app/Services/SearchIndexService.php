<?php

namespace App\Services;

use App\Models\City;
use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * High-performance search index for Indonesian locations.
 *
 * Performance strategy:
 *  - Builds the index with only 4 queries (fetch whole columns into memory),
 *    then joins in-memory via hash maps. No N+1 queries → build < 1 second.
 *  - Caches the built index in the "file" store so it persists across requests.
 *  - search() uses a prefix-bucket + word-boundary scoring so autocomplete
 *    returns in milliseconds without scanning the whole 96k index per keystroke.
 */
class SearchIndexService
{
    protected int $cacheTtl = 86400; // 24h, rebuildable

    /**
     * Build the full search index from DB using batched in-memory joins.
     * Returns an array of entries: { id, type, name, sub, lat, lng, tokens, pop }
     * where 'id' is always a plain numeric Location PK (or entity PK when no Location exists).
     */
    public function buildIndex(): array
    {
        $start = microtime(true);

        // ---- 1. Load all needed rows into memory (only 4 queries) ----
        $locations = Location::where('is_active', true)
            ->get(['id', 'name', 'province_id', 'city_id', 'district_id', 'latitude', 'longitude']);

        $provinces = Province::get(['id', 'name', 'latitude', 'longitude']);
        $cities = City::get(['id', 'name', 'province_id', 'latitude', 'longitude']);
        $districts = District::get(['id', 'name', 'city_id', 'latitude', 'longitude']);
        $villages = Village::get(['id', 'name', 'district_id', 'latitude', 'longitude']);

        // ---- 2. In-memory lookup maps ----
        $provNames = $provinceNameMap = [];
        foreach ($provinces as $p) {
            $provinceNameMap[$p->id] = $p->name;
        }
        $cityMap = [];
        foreach ($cities as $c) {
            $cityMap[$c->id] = [
                'name' => $c->name,
                'province_id' => $c->province_id,
                'province_name' => $provinceNameMap[$c->province_id] ?? '',
            ];
        }
        $districtMap = [];
        foreach ($districts as $d) {
            $districtMap[$d->id] = [
                'name' => $d->name,
                'city_id' => $d->city_id,
            ];
        }

        // Map: district_id => location_id (fast lookup for villages)
        $districtLocation = [];
        foreach ($locations as $l) {
            if ($l->district_id) {
                $districtLocation[$l->district_id] = $l->id;
            }
        }

        // Map: name => location_id (for cities/provinces lookup)
        $nameLocation = [];
        foreach ($locations as $l) {
            $nameLocation[mb_strtolower($l->name)] = $l->id;
        }

        $entries = [];
        $seen = [];

        // ---- 3. Locations (primary selectable) ----
        foreach ($locations as $l) {
            $sub = $this->locationSubFromMaps($l, $cityMap, $provinceNameMap, $districtMap);
            $key = 'l' . $l->name . '|' . $sub;
            if (isset($seen[$key])) continue;
            $seen[$key] = true;

            $entries[] = [
                'id' => (int) $l->id,
                'type' => 'lokasi',
                'name' => $l->name,
                'sub' => $sub,
                'lat' => (float) $l->latitude,
                'lng' => (float) $l->longitude,
                'tokens' => $this->tokenize($l->name . ' ' . $sub),
                'pop' => 5,
            ];
        }

        // ---- 4. Provinces ----
        foreach ($provinces as $p) {
            $this->addEntry($entries, $seen, [
                'id' => (int) ($nameLocation[mb_strtolower($p->name)] ?? $p->id),
                'type' => 'provinsi',
                'name' => $p->name,
                'sub' => 'Indonesia',
                'lat' => (float) $p->latitude,
                'lng' => (float) $p->longitude,
                'pop' => 4,
            ]);
        }

        // ---- 5. Cities ----
        foreach ($cities as $c) {
            $this->addEntry($entries, $seen, [
                'id' => (int) ($nameLocation[mb_strtolower($c->name)] ?? $c->id),
                'type' => 'kota',
                'name' => $c->name,
                'sub' => $provinceNameMap[$c->province_id] ?? '',
                'lat' => (float) $c->latitude,
                'lng' => (float) $c->longitude,
                'pop' => 3,
            ]);
        }

        // ---- 6. Districts ----
        foreach ($districts as $d) {
            $city = $cityMap[$d->city_id] ?? null;
            $sub = ($city['name'] ?? '') . ($city['province_name'] ? ', ' . $city['province_name'] : '');
            $this->addEntry($entries, $seen, [
                'id' => (int) ($nameLocation[mb_strtolower($d->name)] ?? $districtLocation[$d->id] ?? $d->id),
                'type' => 'kecamatan',
                'name' => $d->name,
                'sub' => $sub,
                'lat' => (float) $d->latitude,
                'lng' => (float) $d->longitude,
                'pop' => 2,
            ]);
        }

        // ---- 7. Villages -> map to their district's Location ----
        foreach ($villages as $v) {
            $locId = $districtLocation[$v->district_id] ?? null;
            if (!$locId) continue;

            $district = $districtMap[$v->district_id] ?? null;
            $city = $district ? ($cityMap[$district['city_id']] ?? null) : null;
            $sub = ($district['name'] ?? '') . ($city ? ', ' . $city['name'] : '');

            $this->addEntry($entries, $seen, [
                'id' => (int) $locId,
                'type' => 'desa',
                'name' => $v->name,
                'sub' => $sub,
                'lat' => (float) $v->latitude,
                'lng' => (float) $v->longitude,
                'pop' => 1,
            ]);
        }

        // ---- 8. Sort by priority (pop) desc so high-value entries are scanned first ----
        usort($entries, fn($a, $b) => ($b['pop'] ?? 0) <=> ($a['pop'] ?? 0));

        $elapsed = round((microtime(true) - $start) * 1000, 1);
        Log::info("Search index built: " . count($entries) . " entries in {$elapsed}ms");

        return $entries;
    }

    protected function locationSubFromMaps($l, array $cityMap, array $provinceNameMap, array $districtMap): string
    {
        $parts = [];
        if ($l->city_id && isset($cityMap[$l->city_id])) {
            $parts[] = $cityMap[$l->city_id]['name'];
        }
        if ($l->district_id && isset($districtMap[$l->district_id])) {
            $parts[] = $districtMap[$l->district_id]['name'];
        }
        if ($l->province_id && isset($provinceNameMap[$l->province_id])) {
            $parts[] = $provinceNameMap[$l->province_id];
        }
        return implode(', ', array_unique($parts));
    }

    protected function addEntry(array &$entries, array &$seen, array $entry): void
    {
        $k = $entry['type'] . $entry['name'] . '|' . ($entry['sub'] ?? '');
        if (isset($seen[$k])) return;
        $seen[$k] = true;
        $entry['tokens'] = $this->tokenize($entry['name'] . ' ' . ($entry['sub'] ?? ''));
        $entries[] = $entry;
    }

/**
     * Directory where per-prefix bucket index files are stored.
     * Using PHP files (var_export) + opcache makes loading near-instant,
     * and each request only reads the small bucket files it needs.
     */
    protected function indexDir(): string
    {
        return storage_path('app/search_index');
    }

    /**
     * Build the full index, then write it out as per-prefix PHP files.
     * Returns the total entry count.
     */
    public function rebuild(): array
    {
        $index = $this->buildIndex();

// Group by 2-char lowercase alphanumeric prefix.
        // Also create a secondary "token" bucket so entries like "KOTA BANDUNG"
        // are findable by searching "bandung" (their last/city token).
        $buckets = [];
        $tokenBuckets = [];
        foreach ($index as $entry) {
            $nameLower = mb_strtolower($entry['name']);
            $raw = mb_substr($nameLower, 0, 2);
            $prefix = preg_replace('/[^a-z0-9]/', '', $raw);
            if ($prefix === '') $prefix = 'xx';
            // Compact entry: drop tokens (recomputed cheaply on the fly).
            unset($entry['tokens']);
            $buckets[$prefix][] = $entry;

// Secondary token bucket: index under the "city" token (last word
            // after stripping kabupaten/kota/kecamatan prefix) AND the first
            // significant token, so "KOTA BANDUNG" is findable by "bandung".
            $tokens = $this->tokenize($nameLower);
            if ($tokens) {
                $pt = array_filter($tokens, fn($t) => !in_array($t, ['kabupaten', 'kota', 'kecamatan', 'desa', 'kelurahan'], true));
                $pt = array_values($pt);
                $cands = [];
                if ($pt) {
                    $cands[] = $pt[0];          // e.g. "bandung"
                    $cands[] = end($pt);         // e.g. "bandung"
                }
                foreach (array_unique($cands) as $tk) {
                    if (mb_strlen($tk) >= 3) {
                        $tp = preg_replace('/[^a-z0-9]/', '', mb_substr($tk, 0, 2));
                        if ($tp === '') $tp = 'xx';
                        $tokenBuckets[$tp][] = $entry;
                    }
                }
            }
        }

        // Merge token buckets into the main buckets (dedupe by id).
        foreach ($tokenBuckets as $tp => $entries) {
            $existing = $buckets[$tp] ?? [];
            $ids = [];
            foreach ($existing as $e) $ids[$e['id']] = true;
            foreach ($entries as $e) {
                if (!isset($ids[$e['id']])) {
                    $buckets[$tp][] = $e;
                    $ids[$e['id']] = true;
                }
            }
        }

        $dir = $this->indexDir();
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0775, true) && !is_dir($dir)) {
                throw new \RuntimeException("Failed to create search index directory: {$dir}");
            }
        }

        foreach ($buckets as $prefix => $entries) {
            $result = file_put_contents($dir . '/' . $prefix . '.php', "<?php\nreturn " . var_export($entries, true) . ";\n");
            if ($result === false) {
                Log::error("Failed to write search bucket: {$prefix}");
            }
        }

        $manifestResult = file_put_contents($dir . '/manifest.php', "<?php\nreturn " . var_export(array_keys($buckets), true) . ";\n");
        if ($manifestResult === false) {
            Log::error("Failed to write search index manifest");
        }

        return $index;
    }

    /**
     * Load a single bucket file (small). Returns array of entries.
     */
    protected function loadBucket(string $prefix): array
    {
        $file = $this->indexDir() . '/' . $prefix . '.php';
        if (!file_exists($file)) return [];
        return require $file;
    }

    /**
     * Load the manifest of available prefixes.
     */
    protected function loadManifest(): array
    {
        $file = $this->indexDir() . '/manifest.php';
        if (!file_exists($file)) return [];
        return require $file;
    }

    /**
     * Get the index (for full scans / tooling). Builds if needed.
     * Not used for hot-path search; kept for compatibility.
     */
    public function getIndex(): array
    {
        $manifest = $this->loadManifest();
        if (empty($manifest)) {
            $this->rebuild();
            $manifest = $this->loadManifest();
        }
        $index = [];
        foreach ($manifest as $prefix) {
            foreach ($this->loadBucket($prefix) as $entry) {
                $index[] = $entry;
            }
        }
        return $index;
    }

    /**
     * Fast search: prefix-bucket + token + word-boundary scoring.
     * Returns top matches sorted by relevance.
     *
     * The index is pre-sorted by pop (priority), so we scan and collect
     * until we have enough strong matches, then dedupe + rank.
     */
public function search(string $query, int $limit = 8): array
    {
        $q = mb_strtolower(trim($query));
        if ($q === '') return [];

        $qTokens = $this->tokenize($q);
        $queryLen = mb_strlen($q);

        $results = [];
        $limit2 = $limit * 2;

        // Load only the relevant prefix buckets (fast; each is a small PHP file).
        $candidates = $this->candidateEntries($q);

        foreach ($candidates as $entry) {
            $nameLower = mb_strtolower($entry['name']);
            $subLower = mb_strtolower($entry['sub'] ?? '');
            $entryTokens = $entry['tokens'] ?? $this->tokenize($entry['name'] . ' ' . ($entry['sub'] ?? ''));
            $score = 0;
            $matched = false;

// Exact name match
            if ($nameLower === $q) {
                $score = 1000 + $entry['pop'];
                $matched = true;
            }
            // Whole-word prefix match (e.g. "med" -> "medan")
            elseif ($this->wordPrefixMatch($nameLower, $q)) {
                $score = 850 + $entry['pop'] - ($queryLen / 100);
                $matched = true;
            }
            // Word-boundary substring on name (e.g. "medan" in "kota medan")
            elseif ($this->wordSubstringMatch($nameLower, $q)) {
                $score = 650 + $entry['pop'] - ($queryLen / 100);
                $matched = true;
            }
            // Boost region-level entries (Kota/Kabupaten) when the query is a
            // city token, so "bandung" surfaces "KOTA BANDUNG" before suburbs.
            if ($matched && $queryLen >= 3 && $this->isRegionEntry($entry)) {
                $tokens = $entry['tokens'] ?? $this->tokenize($nameLower . ' ' . ($entry['sub'] ?? ''));
                if (in_array($q, $tokens, true)) {
                    $score += 300;
                }
            }
            // Word-boundary substring on sub (province/city)
            elseif ($this->wordSubstringMatch($subLower, $q)) {
                $score = 450 + $entry['pop'];
                $matched = true;
            }
            // Token-level matching (e.g. "bandung jawa" matches "Kabupaten Bandung, Jawa Barat")
            elseif ($qTokens) {
                $matchCount = 0;
                foreach ($qTokens as $qt) {
                    foreach ($entryTokens as $nt) {
                        if ($nt === $qt) {
                            $matchCount++;
                            break;
                        }
                    }
                }
                if ($matchCount > 0) {
                    $score = 300 + ($matchCount * 50) + $entry['pop'];
                    $matched = true;
                }
            }

            if ($matched) {
                $results[] = [
                    'id' => $entry['id'],
                    'type' => $entry['type'],
                    'name' => $entry['name'],
                    'sub' => $entry['sub'],
                    'lat' => $entry['lat'],
                    'lng' => $entry['lng'],
                    '_score' => $score,
                ];
                if (count($results) >= $limit2) break;
            }
        }

        // Fuzzy fallback only on small sample if few results
        if (count($results) < $limit && $queryLen >= 3) {
            $iterations = 0;
            foreach ($candidates as $entry) {
                if ($iterations++ >= 2000) break;
                $nameLower = mb_strtolower($entry['name']);
                $already = false;
                foreach ($results as $r) {
                    if ($r['name'] === $entry['name'] && $r['type'] === $entry['type']) {
                        $already = true;
                        break;
                    }
                }
                if ($already) continue;

                $entryTokens = $entry['tokens'] ?? $this->tokenize($entry['name'] . ' ' . ($entry['sub'] ?? ''));
                foreach ($entryTokens as $nt) {
                    $dist = levenshtein($nt, $q);
                    $maxLen = max(mb_strlen($nt), $queryLen);
                    if ($maxLen > 0 && $dist <= max(1, intval($queryLen / 4))) {
                        $results[] = [
                            'id' => $entry['id'],
                            'type' => $entry['type'],
                            'name' => $entry['name'],
                            'sub' => $entry['sub'],
                            'lat' => $entry['lat'],
                            'lng' => $entry['lng'],
                            '_score' => 200 - $dist * 20 + $entry['pop'],
                        ];
                        break;
                    }
                }
            }
        }

        usort($results, fn($a, $b) => $b['_score'] <=> $a['_score']);

        // Dedupe by name+type
        $seen = [];
        $out = [];
        foreach ($results as $r) {
            $k = $r['name'] . '|' . $r['type'];
            if (isset($seen[$k])) continue;
            $seen[$k] = true;
            unset($r['_score']);
            $out[] = $r;
            if (count($out) >= $limit) break;
        }

        return $out;
    }

    /**
     * Load the candidate entries for a query by reading only the relevant
     * prefix buckets (exact prefix + a few close buckets sharing the first char).
     * Returns a flat list of entry arrays.
     */
protected function candidateEntries(string $q): array
    {
        $raw = mb_substr($q, 0, 2);
        $prefix = preg_replace('/[^a-z0-9]/', '', $raw);
        if ($prefix === '') $prefix = 'xx';
        if (mb_strlen($prefix) < 2) {
            // Too short: load a handful of popular buckets (empty-prefix unlikely).
            // Fall back to loading the first manifest buckets.
            $manifest = $this->loadManifest();
            $out = [];
            foreach (array_slice($manifest, 0, 5) as $p) {
                $out = array_merge($out, $this->loadBucket($p));
            }
            return $out;
        }

        $manifest = $this->loadManifest();
        $firstChar = mb_substr($prefix, 0, 1);

        $pools = [$prefix];
        foreach ($manifest as $p) {
            if (mb_substr($p, 0, 1) === $firstChar && $p !== $prefix) {
                $pools[] = $p;
                if (count($pools) >= 4) break;
            }
        }

        $out = [];
        foreach ($pools as $p) {
            $out = array_merge($out, $this->loadBucket($p));
        }

        // If too few candidates, broaden with all buckets sharing first char.
        if (count($out) < 200) {
            foreach ($manifest as $p) {
                if (mb_substr($p, 0, 1) === $firstChar && !in_array($p, $pools, true)) {
                    $out = array_merge($out, $this->loadBucket($p));
                }
            }
        }

        return $out;
    }

/**
     * Whether an entry is region-level (provinsi/kota/kabupaten) versus a
     * sub-district (kecamatan/desa). Region-level entries get a boost when
     * the query matches their city token.
     */
    protected function isRegionEntry(array $entry): bool
    {
        $type = $entry['type'] ?? '';
        return in_array($type, ['provinsi', 'kota', 'lokasi'], true);
    }

    protected function wordPrefixMatch(string $text, string $q): bool
    {
        $qLen = mb_strlen($q);
        if ($qLen === 0) return false;

        foreach ($this->tokenize($text) as $word) {
            if (mb_strpos($word, $q) === 0) return true;
        }
        return false;
    }

    protected function wordSubstringMatch(string $text, string $q): bool
    {
        $qLen = mb_strlen($q);
        if ($qLen < 2) return false;

        foreach ($this->tokenize($text) as $word) {
            if ($word === $q) return true;
            $pos = mb_strpos($word, $q);
            if ($pos !== false) {
                if ($pos === 0 || ($pos + $qLen) === mb_strlen($word)) return true;
            }
        }
        return false;
    }

    protected function tokenize(string $text): array
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/\b(kabupaten|kota|kecamatan|desa|kelurahan)\b/', '', $text);
        $words = preg_split('/[\s,\-\.\/]+/', $text);
        $out = [];
        foreach ($words as $w) {
            $w = trim($w);
            if (mb_strlen($w) >= 2) $out[] = $w;
        }
        return $out;
    }
}
