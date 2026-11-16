<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\WeatherAccuracy;
use App\Models\WeatherAlert;
use App\Models\WeatherHistory;
use App\Models\WeatherPrediction;
use App\Services\OpenMeteoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected OpenMeteoService $openMeteo;

    public function __construct(OpenMeteoService $openMeteo)
    {
        $this->openMeteo = $openMeteo;
    }

    public function overview(Request $request): JsonResponse
    {
        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;
        $cacheKey = 'dashboard_overview_v3_' . ($locationId ?? 'default');

        $payload = Cache::remember($cacheKey, 600, function () use ($locationId) {
            $location = Location::with(['province', 'city'])->find($locationId);

// Current weather - try live Open-Meteo, fallback to DB
        $current = null;
        $live = false;
        $daily = null;
        $sunrise = null;
        $sunset = null;
        $uvIndex = null;
        $aqi = null;
        if ($location && $location->latitude && $location->longitude) {
            $raw = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);
            if ($raw) {
                $current = $this->openMeteo->normalizeCurrent($raw);
                $daily = $this->openMeteo->normalizeDaily($raw, 1);
                $sunrise = $daily[0]['sunrise'] ?? null;
                $sunset = $daily[0]['sunset'] ?? null;
                $uvIndex = $daily[0]['uv_index'] ?? null;
                $live = true;
            }
            // Air quality
            $aqRaw = $this->openMeteo->getAirQuality((float) $location->latitude, (float) $location->longitude);
            if ($aqRaw) {
                $cur = $aqRaw['current'] ?? [];
                $usAqi = $cur['us_aqi'] ?? null;
                $aqiLabel = 'Baik';
                $aqiColor = '#43a047';
                if ($usAqi !== null) {
                    if ($usAqi <= 50) { $aqiLabel = 'Baik'; $aqiColor = '#43a047'; }
                    elseif ($usAqi <= 100) { $aqiLabel = 'Sedang'; $aqiColor = '#fdd835'; }
                    elseif ($usAqi <= 150) { $aqiLabel = 'Tidak Sehat'; $aqiColor = '#f57c00'; }
                    elseif ($usAqi <= 200) { $aqiLabel = 'Buruk'; $aqiColor = '#e53935'; }
                    elseif ($usAqi <= 300) { $aqiLabel = 'Sangat Buruk'; $aqiColor = '#b71c1c'; }
                    else { $aqiLabel = 'Berbahaya'; $aqiColor = '#4a148c'; }
                }
                $aqi = [
                    'aqi' => $usAqi,
                    'label' => $aqiLabel,
                    'color' => $aqiColor,
                    'pm25' => $cur['pm2_5'] ?? null,
                    'pm10' => $cur['pm10'] ?? null,
                    'o3' => $cur['ozone'] ?? null,
                    'no2' => $cur['nitrogen_dioxide'] ?? null,
                    'so2' => $cur['sulphur_dioxide'] ?? null,
                    'co' => $cur['carbon_monoxide'] ?? null,
                ];
            }
        }
        if (!$current) {
            $current = WeatherHistory::where('location_id', $locationId)
                ->orderBy('recorded_at', 'desc')
                ->first();
        }

        // Today's predictions
        $todayPredictions = WeatherPrediction::where('location_id', $locationId)
            ->whereDate('forecast_for', now())
            ->orderBy('forecast_for')
            ->get();

        // Active alerts
        $activeAlerts = WeatherAlert::active()
            ->where('location_id', $locationId)
            ->count();

        // Accuracy stats
        $accuracyStats = WeatherAccuracy::where('location_id', $locationId)
            ->select(
                DB::raw('AVG(accuracy_score) as avg_accuracy'),
                DB::raw('COUNT(*) as total_evaluations'),
                DB::raw("SUM(CASE WHEN status = 'correct' THEN 1 ELSE 0 END) as correct_count")
            )
            ->first();

// $current may be an array (live Open-Meteo) OR an Eloquent Model
        // (DB fallback). Normalize to a safe scalar before array access.
        $uvIndexSafe = $uvIndex;
        if (is_array($current)) {
            $uvIndexSafe = $current['uv_index'] ?? $uvIndex;
        } elseif (is_object($current) && isset($current->uv_index)) {
            $uvIndexSafe = $current->uv_index;
        }

            return [
                'success' => true,
                'live' => $live,
                'data' => [
                    'current' => $current,
                    'today_predictions' => $todayPredictions,
                    'active_alerts' => $activeAlerts,
                    'accuracy' => $accuracyStats,
                    'location' => $location,
                    'sunrise' => $sunrise,
                    'sunset' => $sunset,
                    'uv_index' => $uvIndexSafe,
                    'air_quality' => $aqi,
                ],
            ];
        });

        return response()->json($payload);
    }

    public function statistics(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'period' => 'nullable|in:7,14,30,90',
        ]);

        $locationId = $request->location_id;
        $days = $request->period ?? 7;
        $cacheKey = 'dashboard_stats_' . ($locationId ?? 'all') . '_' . $days;

        $stats = Cache::remember($cacheKey, 300, function () use ($locationId, $days) {
            $since = now()->subDays($days);
            $query = WeatherHistory::where('recorded_at', '>=', $since);
            if ($locationId) {
                $query->where('location_id', $locationId);
            }

            return $query->select(
                DB::raw('DATE(recorded_at) as date'),
                DB::raw('AVG(temperature) as avg_temp'),
                DB::raw('MAX(temperature) as max_temp'),
                DB::raw('MIN(temperature) as min_temp'),
                DB::raw('AVG(humidity) as avg_humidity'),
                DB::raw('AVG(wind_speed) as avg_wind_speed'),
                DB::raw('SUM(rain_1h) as total_rain'),
                DB::raw('AVG(pressure) as avg_pressure'),
            )
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        });

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    public function topCities(): JsonResponse
    {
        $data = Cache::remember('dashboard_top_cities', 300, function () {
            // Hotest cities - last 24 hours
            $hottest = Location::select([
                    'locations.id',
                    'locations.name',
                    'locations.slug',
                    DB::raw('AVG(weather_history.temperature) as avg_temp'),
                    DB::raw('COUNT(*) as data_points')
                ])
                ->join('weather_history', 'locations.id', '=', 'weather_history.location_id')
                ->where('weather_history.recorded_at', '>=', now()->subDay())
                ->whereNotNull('weather_history.temperature')
                ->groupBy('locations.id', 'locations.name', 'locations.slug')
                ->orderByDesc('avg_temp')
                ->limit(10)
                ->get();

            // Coldest cities - last 24 hours
            $coldest = Location::select([
                    'locations.id',
                    'locations.name',
                    'locations.slug',
                    DB::raw('AVG(weather_history.temperature) as avg_temp'),
                    DB::raw('COUNT(*) as data_points')
                ])
                ->join('weather_history', 'locations.id', '=', 'weather_history.location_id')
                ->where('weather_history.recorded_at', '>=', now()->subDay())
                ->whereNotNull('weather_history.temperature')
                ->groupBy('locations.id', 'locations.name', 'locations.slug')
                ->orderBy('avg_temp')
                ->limit(10)
                ->get();

            // Rainiest cities - last 24 hours
            $rainiest = Location::select([
                    'locations.id',
                    'locations.name',
                    'locations.slug',
                    DB::raw('SUM(weather_history.rain_1h) as total_rain'),
                    DB::raw('COUNT(*) as data_points')
                ])
                ->join('weather_history', 'locations.id', '=', 'weather_history.location_id')
                ->where('weather_history.recorded_at', '>=', now()->subDay())
                ->whereNotNull('weather_history.rain_1h')
                ->groupBy('locations.id', 'locations.name', 'locations.slug')
                ->orderByDesc('total_rain')
                ->limit(10)
                ->get();

            // Windiest cities - last 24 hours
            $windiest = Location::select([
                    'locations.id',
                    'locations.name',
                    'locations.slug',
                    DB::raw('AVG(weather_history.wind_speed) as avg_wind'),
                    DB::raw('COUNT(*) as data_points')
                ])
                ->join('weather_history', 'locations.id', '=', 'weather_history.location_id')
                ->where('weather_history.recorded_at', '>=', now()->subDay())
                ->whereNotNull('weather_history.wind_speed')
                ->groupBy('locations.id', 'locations.name', 'locations.slug')
                ->orderByDesc('avg_wind')
                ->limit(10)
                ->get();

            return [
                'hottest' => $hottest,
                'coldest' => $coldest,
                'rainiest' => $rainiest,
                'windiest' => $windiest,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function analytics(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
        ]);

        $locationId = $request->location_id;
        $cacheKey = 'dashboard_analytics_' . ($locationId ?? 'all') . '_' . now()->format('YmdH');

        $data = Cache::remember($cacheKey, 300, function () use ($locationId) {
            $dbDriver = DB::connection()->getDriverName();

            // Hourly temperature trend for today - compatible with SQLite, MySQL, PostgreSQL
            $hourExpr = match ($dbDriver) {
                'pgsql' => "EXTRACT(HOUR FROM recorded_at)::text",
                'mysql' => "DATE_FORMAT(recorded_at, '%H')",
                default => "strftime('%H', recorded_at)", // SQLite
            };

            $hourlyTemp = WeatherHistory::whereDate('recorded_at', now())
                ->when($locationId, fn($q) => $q->where('location_id', $locationId))
                ->select(
                    DB::raw("{$hourExpr} as hour"),
                    DB::raw('AVG(temperature) as avg_temp'),
                    DB::raw('AVG(humidity) as avg_humidity')
                )
                ->groupBy(DB::raw($hourExpr))
                ->orderBy('hour')
                ->get();

            // Weather distribution
            $weatherDistribution = WeatherHistory::whereDate('recorded_at', now())
                ->when($locationId, fn($q) => $q->where('location_id', $locationId))
                ->select('weather_main', DB::raw('COUNT(*) as count'))
                ->groupBy('weather_main')
                ->get();

            // Wind rose data
            $windData = WeatherHistory::whereDate('recorded_at', now())
                ->when($locationId, fn($q) => $q->where('location_id', $locationId))
                ->select(
                    DB::raw('AVG(wind_speed) as avg_speed'),
                    DB::raw('AVG(wind_deg) as avg_direction')
                )
                ->first();

            return [
                'hourly_temperature' => $hourlyTemp,
                'weather_distribution' => $weatherDistribution,
                'wind' => $windData,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Get weather match score - compare predictions with actual weather
     */
    public function weatherMatch(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'date' => 'nullable|date',
        ]);

        $locationId = $request->location_id;
        $date = $request->date ?: now()->toDateString();

        // Get predictions for the date
        $predictions = WeatherPrediction::whereDate('forecast_for', $date)
            ->when($locationId, fn($q) => $q->where('location_id', $locationId))
            ->get()
            ->keyBy(fn($item) => $item->location_id . '-' . $item->forecast_for->format('H'));

        // Get actual weather for the date
        $actuals = WeatherHistory::whereDate('recorded_at', $date)
            ->when($locationId, fn($q) => $q->where('location_id', $locationId))
            ->get()
            ->groupBy(fn($item) => $item->location_id . '-' . $item->recorded_at->format('H'));

        // Match them
        $matches = [];
        $correctCount = 0;
        $totalCount = 0;

        foreach ($predictions as $key => $prediction) {
            $actual = $actuals->get($key)?->first();
            if (!$actual || !$actual->weather_main) continue;

            $totalCount++;
            $isCorrect = strtolower($prediction->weather_main) === strtolower($actual->weather_main);
            if ($isCorrect) $correctCount++;

            $tempDiff = ($actual->temperature !== null && $prediction->temperature !== null)
                ? abs($actual->temperature - $prediction->temperature)
                : null;

            $matches[] = [
                'hour' => $prediction->forecast_for->format('H:00'),
                'predicted' => [
                    'weather' => $prediction->weather_main,
                    'description' => $prediction->weather_description,
                    'temperature' => $prediction->temperature,
                    'humidity' => $prediction->humidity,
                    'wind_speed' => $prediction->wind_speed,
                ],
                'actual' => [
                    'weather' => $actual->weather_main,
                    'description' => $actual->weather_description,
                    'temperature' => $actual->temperature,
                    'humidity' => $actual->humidity,
                    'wind_speed' => $actual->wind_speed,
                ],
                'match' => $isCorrect,
                'temperature_diff' => $tempDiff,
            ];
        }

        $matchRate = $totalCount > 0 ? round(($correctCount / $totalCount) * 100, 1) : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $date,
                'total_comparisons' => $totalCount,
                'correct' => $correctCount,
                'incorrect' => $totalCount - $correctCount,
                'match_rate' => $matchRate,
                'details' => $matches,
            ],
        ]);
    }
}
