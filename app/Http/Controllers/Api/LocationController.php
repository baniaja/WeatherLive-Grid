<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    public function provinces(): JsonResponse
    {
        $provinces = Province::orderBy('name')->get();
        return response()->json(['success' => true, 'data' => $provinces]);
    }

    public function cities(Request $request): JsonResponse
    {
        $request->validate(['province_id' => 'nullable|exists:provinces,id']);

        $query = City::with('province');
        if ($request->province_id) {
            $query->where('province_id', $request->province_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('name')->get(),
        ]);
    }

    public function districts(Request $request): JsonResponse
    {
        $request->validate(['city_id' => 'nullable|exists:cities,id']);

        $query = District::with('city');
        if ($request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('name')->get(),
        ]);
    }

    public function villages(Request $request): JsonResponse
    {
        $request->validate(['district_id' => 'nullable|exists:districts,id']);

        $query = Village::with('district');
        if ($request->district_id) {
            $query->where('district_id', $request->district_id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('name')->get(),
        ]);
    }

    /**
     * Google-like search autocomplete (super accurate with live geocoding fallback)
     * Returns grouped results: Provinces, Cities, Districts, Villages, Locations
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:1']);

        $q = trim($request->q);
        $limit = $request->limit ?? 5;

// ---- Local database first (fast, reliable) ----
        // Each item carries a plain numeric 'id' that is a valid Location PK
        // (locations.id) so the frontend can pass it directly to weather APIs.
        $provincesArr = Province::where('name', 'like', "%{$q}%")
            ->limit($limit)
            ->get();

        $citiesArr = City::where('name', 'like', "%{$q}%")
            ->with('province:id,name')
            ->limit($limit)
            ->get();

        $districtsArr = District::where('name', 'like', "%{$q}%")
            ->with('city.province')
            ->limit($limit)
            ->get();

        $villagesArr = Village::where('name', 'like', "%{$q}%")
            ->with('district.city.province')
            ->limit($limit)
            ->get();

        $locationsArr = Location::where('name', 'like', "%{$q}%")
            ->with(['province:id,name', 'city:id,name', 'district:id,name'])
            ->limit($limit)
            ->get();

        // Resolve location IDs in a single bulk query to prevent N+1 query overhead
        $allNames = collect()
            ->merge($provincesArr->pluck('name'))
            ->merge($citiesArr->pluck('name'))
            ->merge($districtsArr->pluck('name'))
            ->merge($villagesArr->pluck('name'))
            ->unique()
            ->filter();

        $locationMap = !empty($allNames)
            ? Location::whereIn('name', $allNames)->pluck('id', 'name')->all()
            : [];

        // Resolve a location id for each entity (fallback: match by name or item id)
        $provinces = $provincesArr->map(fn($p) => ['type' => 'provinsi', 'id' => (int)($locationMap[$p->name] ?? $p->id), 'name' => $p->name, 'sub' => 'Indonesia', 'lat' => $p->latitude, 'lng' => $p->longitude]);
        $cities = $citiesArr->map(fn($c) => ['type' => 'kota', 'id' => (int)($locationMap[$c->name] ?? $c->id), 'name' => $c->name, 'sub' => $c->province?->name ?? '', 'lat' => $c->latitude, 'lng' => $c->longitude]);
        $districts = $districtsArr->map(fn($d) => ['type' => 'kecamatan', 'id' => (int)($locationMap[$d->name] ?? $d->id), 'name' => $d->name, 'sub' => $d->city?->name . ', ' . ($d->city?->province?->name ?? ''), 'lat' => $d->latitude, 'lng' => $d->longitude]);
        $villages = $villagesArr->map(fn($v) => ['type' => 'desa', 'id' => (int)($locationMap[$v->name] ?? $v->id), 'name' => $v->name, 'sub' => $v->district?->name . ', ' . ($v->district?->city?->name ?? ''), 'lat' => $v->latitude, 'lng' => $v->longitude]);
        $locations = $locationsArr->map(function ($l) {
            $sub = $l->city?->name ?? $l->district?->name ?? '';
            if ($l->province) $sub = $sub ? $sub . ', ' . $l->province->name : $l->province->name;
            return ['type' => 'lokasi', 'id' => (int)$l->id, 'name' => $l->name, 'sub' => $sub, 'lat' => (float)$l->latitude, 'lng' => (float)$l->longitude];
        });

        $all = collect()
            ->merge($provinces)
            ->merge($cities)
            ->merge($districts)
            ->merge($villages)
            ->merge($locations)
            ->sortBy(fn($i) => mb_strtolower($i['name']))
            ->values();

        // If local DB found nothing, fall back to live geocoding (super accurate)
        if ($all->isEmpty()) {
            $geocoded = $this->geocodeIndonesia($q, $limit);
            if (!empty($geocoded)) {
                $all = collect($geocoded);
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'provinces' => $provinces,
                'cities' => $cities,
                'districts' => $districts,
                'villages' => $villages,
                'locations' => $locations,
            ],
            'all' => $all,
        ]);
    }

    /**
     * Live geocoding via OpenStreetMap Nominatim for Indonesian places.
     * Returns [type, id, name, sub, lat, lng] entries and persists to locations table
     * so weather data can be tied to the spot.
     */
    protected function geocodeIndonesia(string $query, int $limit): array
    {
        $results = [];
        try {
            $response = Http::timeout(8)
                ->withHeaders(['User-Agent' => 'WeatherLive-Grid/1.0 (weather app)'])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $query . ' Indonesia',
                    'format' => 'json',
                    'countrycodes' => 'id',
                    'limit' => $limit,
                    'addressdetails' => 1,
                ]);

            if (!$response->successful()) {
                Log::warning('Nominatim geocoding error: ' . $response->status());
                return [];
            }

            // Normalize the query terms to build a better label
            $qLower = mb_strtolower($query);

            foreach ($response->json() as $item) {
                $lat = (float)($item['lat'] ?? 0);
                $lng = (float)($item['lon'] ?? 0);
                if (!$lat || !$lng) continue;

                $name = $this->extractName($item);
                $sub = $this->extractSub($item);
                $type = $this->mapOsmType($item ?? []);

                // Build a stable slug for dedup / persistence
                $slug = Str::slug($name . '-' . $lat . '-' . $lng);

                // Persist (updateOrCreate) so location gets an id and weather can attach to it
                $location = Location::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $name,
                        'latitude' => $lat,
                        'longitude' => $lng,
                        'timezone' => 'Asia/Jakarta',
                        'is_active' => true,
                        'province_id' => $this->resolveProvince($sub),
                    ]
                );

$results[] = [
                    'type' => $type,
                    'id' => (int)$location->id,   // plain numeric Location PK for weather lookup
                    'name' => $name,
                    'sub' => $sub,
                    'lat' => $lat,
                    'lng' => $lng,
                ];
            }
        } catch (\Exception $e) {
            Log::error('Nominatim geocoding exception: ' . $e->getMessage());
        }

        return $results;
    }

    /**
     * Extract a clean display name from a Nominatim result, preferring the type-specific name.
     */
    protected function extractName(array $item): string
    {
        $addr = $item['address'] ?? [];
        $qLower = mb_strtolower(trim($item['display_name'] ?? ''));

        // Prefer the most specific region: village -> suburb -> city_district -> county
        $candidate = $addr['village'] ?? $addr['suburb'] ?? $addr['city_district'] ?? $addr['town'] ?? $addr['municipality'] ?? $addr['city'] ?? $addr['hamlet'] ?? '';

        if ($candidate && mb_strlen($candidate) >= 2) {
            return $this->cleanName($candidate);
        }

        // Fallback: use display_name first part before first comma
        $parts = explode(',', $item['display_name'] ?? '');
        $first = trim($parts[0] ?? '');
        return $this->cleanName($first) ?: 'Lokasi';
    }

    /**
     * Build a location subtitle from an address object.
     */
    protected function extractSub(array $item): string
    {
        $addr = $item['address'] ?? [];
        $parts = [];
        foreach (['village', 'suburb', 'town', 'city_district', 'municipality', 'county', 'city', 'state'] as $key) {
            if (!empty($addr[$key])) {
                $parts[] = $addr[$key];
            }
        }
        $parts = array_unique($parts);
        return implode(', ', $parts);
    }

    /**
     * Map OpenStreetMap place type to our type label.
     */
    protected function mapOsmType(array $item): string
    {
        $class = $item['class'] ?? '';
        $type = $item['type'] ?? '';
        $addr = $item['address'] ?? [];

        if ($type === 'administrative' && isset($addr['village'])) return 'desa';
        if ($type === 'administrative' && (isset($addr['suburb']) || isset($addr['city_district']))) return 'kecamatan';
        if ($type === 'administrative' && isset($addr['county'])) return 'kota';
        if ($class === 'place') {
            $placeType = $type;
            if (in_array($placeType, ['city', 'town', 'municipality', 'county'])) return 'kota';
            if (in_array($placeType, ['suburb', 'borough', 'quarter', 'neighbourhood'])) return 'kecamatan';
            if (in_array($placeType, ['village', 'hamlet', 'island', 'locality'])) return 'desa';
            if (in_array($placeType, ['province', 'state'])) return 'provinsi';
        }
        return 'lokasi';
    }

    /**
     * Remove "Kecamatan/Desa/Kota" prefixes for cleaner display name.
     */
    protected function cleanName(string $name): string
    {
        $name = trim($name);
        $name = preg_replace('/^(Kecamatan|Kelurahan|Desa|Kota|Kabupaten)\s+/i', '', $name);
        return $name;
    }

    /**
     * Find or create a province by name (matched by extractSub).
     */
    protected function resolveProvince(string $sub): ?int
    {
        foreach (explode(',', $sub) as $part) {
            $part = trim($part);
            if (!$part) continue;
            $province = Province::where('name', $part)->orWhere('name', 'like', '%' . $part . '%')->first();
            if ($province) return $province->id;
        }
        return null;
    }

    /**
     * Find an existing Location that matches this name.
     * Used to return a plain numeric location id for province/city/district/village search items.
     */
    protected function locationIdForName(string $name): ?int
    {
        return Location::where('name', $name)->value('id')
            ?? Location::where('name', 'like', $name)->value('id')
            ?? null;
    }

    /**
     * Simple search for frontend dropdown - returns flat array of locations
     */
    public function searchFlat(Request $request): JsonResponse
    {
        $request->validate(['q' => 'nullable|string']);

        $q = $request->q;
        $limit = $request->limit ?? 50;

        $query = Location::with(['province:id,name', 'city:id,name'])
            ->where('is_active', true);

        if ($q) {
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhereHas('province', fn($p) => $p->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('city', fn($c) => $c->where('name', 'like', "%{$q}%"));
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('name')->limit($limit)->get(),
        ]);
    }

    public function show(Location $location): JsonResponse
    {
        $location->load(['province', 'city', 'district', 'village']);
        return response()->json([
            'success' => true,
            'data' => $location,
        ]);
    }
}
