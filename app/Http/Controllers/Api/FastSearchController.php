<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\WeatherHistory;
use App\Services\OpenMeteoService;
use App\Services\SearchIndexService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Fast Search Engine for WeatherLive-Grid.
 * Implements the ideal search flow:
 *  1. User types -> instant suggestions (cached index, ms)
 *  2. On select -> instant weather snapshot from cache
 *  3. Progressive: hourly/daily/AQI/radar load lazily
 *  4. AI summary / recommendations
 */
class FastSearchController extends Controller
{
    protected SearchIndexService $searchIndex;
    protected OpenMeteoService $openMeteo;

    public function __construct(SearchIndexService $searchIndex, OpenMeteoService $openMeteo)
    {
        $this->searchIndex = $searchIndex;
        $this->openMeteo = $openMeteo;
    }

    /**
     * GET /api/search/suggestions?q=...&limit=8
     * Returns autocomplete suggestions in milliseconds from the cached index.
     */
    public function suggestions(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:1',
            'limit' => 'nullable|integer|min:1|max:20',
        ]);

        $q = trim($request->q);
        $limit = $request->limit ?? 8;

        $start = microtime(true);
        $results = $this->searchIndex->search($q, $limit);
        $elapsed = round((microtime(true) - $start) * 1000, 1);

        return response()->json([
            'success' => true,
            'query' => $q,
            'count' => count($results),
            'elapsed_ms' => $elapsed,
            'data' => $results,
        ]);
    }

    /**
     * GET /api/search/instant?location_id=...
     * Returns instantly-cached weather snapshot for a selected location.
     * Uses a short cache so repeat selections are near-instant.
     */
    public function instant(Request $request): JsonResponse
    {
        $location = null;
        if ($request->filled('location_id')) {
            $location = Location::with(['province', 'city'])->find($request->location_id);
        } elseif ($request->filled('q')) {
            $q = trim($request->q);
            $location = Location::with(['province', 'city'])
                ->where('name', 'like', "%{$q}%")
                ->orWhereHas('district', fn($d) => $d->where('name', 'like', "%{$q}%"))
                ->first();
        } else {
            $location = Location::with(['province', 'city'])->where('is_active', true)->first();
        }

        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $cacheKey = 'instant_weather_' . $location->id;
        $snapshot = Cache::remember($cacheKey, 120, function () use ($location) {
            $current = null;
            $live = false;
            if ($location->latitude && $location->longitude) {
                $raw = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);
                if ($raw) {
                    $current = $this->openMeteo->normalizeCurrent($raw);
                    $live = true;
                }
            }
            if (!$current) {
                $current = WeatherHistory::where('location_id', $location->id)
                    ->orderBy('recorded_at', 'desc')
                    ->first();
            }

            return [
                'current' => $current,
                'location' => $location,
                'live' => $live,
            ];
        });

        return response()->json([
            'success' => true,
            'live' => $snapshot['live'],
            'cached' => Cache::has($cacheKey),
            'data' => [
                'location' => $snapshot['location'],
                'current' => $snapshot['current'],
            ],
        ]);
    }

    /**
     * GET /api/search/details?location_id=...
     * Returns the full detail payload (hourly + daily + AQI) for progressive loading.
     */
    public function details(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'required|exists:locations,id']);

        $location = Location::with(['province', 'city'])->find($request->location_id);
        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $hourly = [];
        $daily = [];
        $aqi = null;

        if ($location->latitude && $location->longitude) {
            $raw = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);
            if ($raw) {
                $hourly = $this->openMeteo->normalizeHourly($raw, 24);
                $daily = $this->openMeteo->normalizeDaily($raw, 7);
            }

            $aqRaw = $this->openMeteo->getAirQuality((float) $location->latitude, (float) $location->longitude);
            if ($aqRaw) {
                $cur = $aqRaw['current'] ?? [];
                $aqi = [
                    'aqi' => $cur['us_aqi'] ?? null,
                    'pm25' => $cur['pm2_5'] ?? null,
                    'pm10' => $cur['pm10'] ?? null,
                    'o3' => $cur['ozone'] ?? null,
                    'no2' => $cur['nitrogen_dioxide'] ?? null,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'location' => $location,
                'hourly' => $hourly,
                'daily' => $daily,
                'air_quality' => $aqi,
            ],
        ]);
    }

    /**
     * GET /api/search/summary?location_id=...
     * Returns a lightweight AI-style summary + activity recommendations
     * based on current weather, without external LLM latency.
     */
public function summary(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'nullable|exists:locations,id']);

        // location_id is optional: fall back to the first active, geolocated
        // location so the dashboard AI summary never fails before a selection.
        $location = $request->location_id
            ? Location::with(['province', 'city'])->find($request->location_id)
            : Location::with(['province', 'city'])
                ->where('is_active', true)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->first();

        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak tersedia.'], 404);
        }

        $current = null;
        if ($location->latitude && $location->longitude) {
            $raw = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);
            if ($raw) $current = $this->openMeteo->normalizeCurrent($raw);
        }
        if (!$current) {
            $current = WeatherHistory::where('location_id', $location->id)
                ->orderBy('recorded_at', 'desc')
                ->first();
        }

        $summary = $this->buildSummary($current, $location);

        return response()->json([
            'success' => true,
            'data' => $summary,
        ]);
    }

    /**
     * Rebuild the search index (admin / maintenance).
     */
    public function rebuild(): JsonResponse
    {
        $count = count($this->searchIndex->rebuild());
        return response()->json([
            'success' => true,
            'message' => "Index dibangun ulang. {$count} entri.",
            'count' => $count,
        ]);
    }

    /**
     * Build a text summary + activity recommendations from weather data.
     */
    protected function buildSummary($current, $location): array
    {
        if (!$current) {
            return [
                'location' => $location->name,
                'text' => 'Data cuaca belum tersedia untuk lokasi ini.',
                'recommendations' => [],
                'score' => 50,
            ];
        }

        $temp = (float) ($current['temperature'] ?? ($current->temperature ?? 0));
        $desc = $current['weather_description'] ?? ($current->weather_description ?? 'Berawan');
        $humidity = (int) ($current['humidity'] ?? ($current->humidity ?? 0));
        $wind = (float) ($current['wind_speed'] ?? ($current->wind_speed ?? 0));
        $rain = (float) ($current['rain_1h'] ?? ($current->rain_1h ?? 0));
        $uv = (float) ($current['uv_index'] ?? ($current->uv_index ?? 0));

        $descLower = mb_strtolower($desc);
        $isRainy = str_contains($descLower, 'hujan') || $rain > 0;
        $isSunny = str_contains($descLower, 'cerah') && !$isRainy;
        $isCloudy = str_contains($descLower, 'awan') && !$isRainy;

        // Compose natural-language summary
        $parts = [];

        if ($isRainy) {
            $parts[] = "Sedang turun hujan di {$location->name} dengan suhu {$temp}°C.";
        } elseif ($isSunny) {
            $parts[] = "Cuaca cerah di {$location->name} dengan suhu {$temp}°C.";
        } elseif ($isCloudy) {
            $parts[] = "Langit berawan di {$location->name} dengan suhu {$temp}°C.";
        } else {
            $parts[] = "Kondisi {$desc} di {$location->name} dengan suhu {$temp}°C.";
        }

        if ($humidity > 80) $parts[] = "Kelembapan tinggi ({$humidity}%), udara terasa lembap.";
        elseif ($humidity < 40) $parts[] = "Udara cukup kering ({$humidity}%).";

        if ($wind > 8) $parts[] = "Angin cukup kencang ({$wind} m/s).";
        elseif ($wind > 3) $parts[] = "Angin sedang ({$wind} m/s).";

        if ($uv > 7) $parts[] = "Paparan UV tinggi ({$uv}). Gunakan tabir surya.";
        elseif ($uv > 3) $parts[] = "UV moderat ({$uv}).";

        $text = implode(' ', $parts);

        // Recommendations
        $recs = [];
        if ($isRainy) {
            $recs[] = ['icon' => 'umbrella', 'label' => 'Bawa payung/jas hujan', 'detail' => 'Hujan sedang turun'];
            $recs[] = ['icon' => 'car', 'label' => 'Hati-hati berkendara', 'detail' => 'Jalan bisa licin'];
            $recs[] = ['icon' => 'home', 'label' => 'Kurangi aktivitas outdoor', 'detail' => 'Gunakan waktu di dalam ruangan'];
        } elseif ($isSunny) {
            $recs[] = ['icon' => 'sun', 'label' => 'Cocok untuk outdoor', 'detail' => 'Cuaca cerah'];
            $recs[] = ['icon' => 'skincare', 'label' => 'Pakai tabir surya', 'detail' => $uv > 3 ? 'UV ' . $uv : 'UV rendah'];
            $recs[] = ['icon' => 'water', 'label' => 'Minum air cukup', 'detail' => 'Cuaca panas'];
        } elseif ($isCloudy) {
            $recs[] = ['icon' => 'walk', 'label' => 'Cocok untuk jalan-jalan', 'detail' => 'Tidak terlalu panas'];
            $recs[] = ['icon' => 'bike', 'label' => 'Olahraga ringan', 'detail' => 'Kondisi nyaman'];
        } else {
            $recs[] = ['icon' => 'info', 'label' => 'Periksa prakiraan', 'detail' => 'Kondisi berubah'];
        }

        return [
            'location' => $location->name,
            'text' => $text,
            'recommendations' => $recs,
            'score' => $this->computeScore($temp, $humidity, $wind, $rain, $uv),
        ];
    }

    protected function computeScore(float $temp, int $humidity, float $wind, float $rain, float $uv): int
    {
        $score = 100;
        if ($temp > 34 || $temp < 18) $score -= 20;
        if ($humidity > 85 || $humidity < 30) $score -= 10;
        if ($wind > 10) $score -= 15;
        if ($rain > 0) $score -= 25;
        if ($uv > 9) $score -= 10;
        return max(0, min(100, $score));
    }
}
