<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\WeatherHistory;
use App\Models\WeatherPrediction;
use App\Models\SiteSetting;
use App\Models\PortalFeature;
use App\Models\WeatherBulletin;
use App\Services\OpenMeteoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    protected OpenMeteoService $openMeteo;

    public function __construct(OpenMeteoService $openMeteo)
    {
        $this->openMeteo = $openMeteo;
    }

    /**
     * Get real-time weather. Tries Open-Meteo live data first, falls back to DB.
     */
    public function current(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'nullable|exists:locations,id']);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $location = Location::with(['province', 'city'])->find($locationId);

        if (!$location) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        // For geocoded locations without lat/lng relationship, use saved coords
        $liveData = null;
        if ($location->latitude && $location->longitude) {
            $raw = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);
            if ($raw) {
                $liveData = $this->openMeteo->normalizeCurrent($raw);
            }
        }

        if ($liveData) {
            return response()->json([
                'success' => true,
                'live' => true,
                'source' => 'Open-Meteo',
                'data' => [
                    'location' => $location,
                    'current' => $liveData,
                    'updated_at' => now(),
                ],
            ]);
        }

        // Fallback to DB
        $current = WeatherHistory::where('location_id', $locationId)
            ->orderBy('recorded_at', 'desc')
            ->first();

        if (!$current) {
            return response()->json(['success' => false, 'message' => 'Data cuaca tidak tersedia.'], 404);
        }

        return response()->json([
            'success' => true,
            'live' => false,
            'source' => 'Database',
            'data' => [
                'location' => $location,
                'current' => $current,
                'updated_at' => $current->recorded_at,
            ],
        ]);
    }

    /**
     * Resolve latitude and longitude from request (location_id, city_code, lat/lon, or default)
     */
    protected function resolveLocationCoords(Request $request): ?array
    {
        if ($request->filled('lat') && $request->filled('lon')) {
            return [
                'name' => $request->name ?? 'Koordinat Kustom',
                'lat' => (float) $request->lat,
                'lon' => (float) $request->lon,
            ];
        }

        $cityCodeCoords = [
            '31.71' => ['name' => 'DKI Jakarta', 'lat' => -6.2088, 'lon' => 106.8456],
            '32.73' => ['name' => 'Kota Bandung', 'lat' => -6.9175, 'lon' => 107.6191],
            '32.71' => ['name' => 'Kota Bogor', 'lat' => -6.5971, 'lon' => 106.8060],
            '32.75' => ['name' => 'Kota Bekasi', 'lat' => -6.2383, 'lon' => 106.9756],
            '32.76' => ['name' => 'Kota Depok', 'lat' => -6.4025, 'lon' => 106.7942],
            '32.74' => ['name' => 'Kota Cirebon', 'lat' => -6.7320, 'lon' => 108.5523],
            '32.72' => ['name' => 'Kota Sukabumi', 'lat' => -6.9277, 'lon' => 106.9299],
            '32.77' => ['name' => 'Kota Cimahi', 'lat' => -6.8723, 'lon' => 107.5422],
            '32.78' => ['name' => 'Kota Tasikmalaya', 'lat' => -7.3274, 'lon' => 108.2207],
            '32.79' => ['name' => 'Kota Banjar', 'lat' => -7.3686, 'lon' => 108.5332],
            '32.01' => ['name' => 'Kabupaten Bogor', 'lat' => -6.5518, 'lon' => 106.6291],
            '32.04' => ['name' => 'Kabupaten Bandung', 'lat' => -7.0253, 'lon' => 107.5198],
            '32.17' => ['name' => 'Kabupaten Bandung Barat', 'lat' => -6.8441, 'lon' => 107.5029],
            '32.16' => ['name' => 'Kabupaten Bekasi', 'lat' => -6.2415, 'lon' => 107.1354],
            '32.07' => ['name' => 'Kabupaten Ciamis', 'lat' => -7.3259, 'lon' => 108.3533],
            '32.03' => ['name' => 'Kabupaten Cianjur', 'lat' => -6.8223, 'lon' => 107.1396],
            '32.09' => ['name' => 'Kabupaten Cirebon', 'lat' => -6.7578, 'lon' => 108.5348],
            '32.05' => ['name' => 'Kabupaten Garut', 'lat' => -7.2278, 'lon' => 107.9086],
            '32.12' => ['name' => 'Kabupaten Indramayu', 'lat' => -6.3263, 'lon' => 108.3200],
            '32.15' => ['name' => 'Kabupaten Karawang', 'lat' => -6.3039, 'lon' => 107.3059],
            '32.08' => ['name' => 'Kabupaten Kuningan', 'lat' => -6.9764, 'lon' => 108.4831],
            '32.10' => ['name' => 'Kabupaten Majalengka', 'lat' => -6.8361, 'lon' => 108.2274],
            '32.18' => ['name' => 'Kabupaten Pangandaran', 'lat' => -7.6833, 'lon' => 108.6500],
            '32.14' => ['name' => 'Kabupaten Purwakarta', 'lat' => -6.5569, 'lon' => 107.4433],
            '32.13' => ['name' => 'Kabupaten Subang', 'lat' => -6.5716, 'lon' => 107.7587],
            '32.02' => ['name' => 'Kabupaten Sukabumi', 'lat' => -6.9833, 'lon' => 106.7000],
            '32.11' => ['name' => 'Kabupaten Sumedang', 'lat' => -6.8586, 'lon' => 107.9269],
            '32.06' => ['name' => 'Kabupaten Tasikmalaya', 'lat' => -7.3516, 'lon' => 108.2144],
            '35.78' => ['name' => 'Kota Surabaya', 'lat' => -7.2575, 'lon' => 112.7521],
            '33.74' => ['name' => 'Kota Semarang', 'lat' => -6.9667, 'lon' => 110.4167],
            '34.71' => ['name' => 'Kota Yogyakarta', 'lat' => -7.7956, 'lon' => 110.3695],
            '51.71' => ['name' => 'Kota Denpasar', 'lat' => -8.6705, 'lon' => 115.2126],
            '12.71' => ['name' => 'Kota Medan', 'lat' => 3.5952, 'lon' => 98.6722],
            '73.71' => ['name' => 'Kota Makassar', 'lat' => -5.1477, 'lon' => 119.4327],
            '16.71' => ['name' => 'Kota Palembang', 'lat' => -2.9761, 'lon' => 104.7754],
            '64.71' => ['name' => 'Kota Balikpapan', 'lat' => -1.2654, 'lon' => 116.8312],
            '71.71' => ['name' => 'Kota Manado', 'lat' => 1.4748, 'lon' => 124.8428],
        ];

        if ($request->filled('city_code') && isset($cityCodeCoords[$request->city_code])) {
            return $cityCodeCoords[$request->city_code];
        }

        if ($request->filled('location_id')) {
            $loc = Location::find($request->location_id);
            if ($loc && $loc->latitude && $loc->longitude) {
                return [
                    'name' => $loc->name,
                    'lat' => (float) $loc->latitude,
                    'lon' => (float) $loc->longitude,
                    'location' => $loc
                ];
            }
        }

        $loc = Location::where('is_active', true)->first();
        if ($loc && $loc->latitude && $loc->longitude) {
            return [
                'name' => $loc->name,
                'lat' => (float) $loc->latitude,
                'lon' => (float) $loc->longitude,
                'location' => $loc
            ];
        }

        return ['name' => 'DKI Jakarta', 'lat' => -6.2088, 'lon' => 106.8456];
    }

    /**
     * Hourly forecast - live from Open-Meteo, fallback to DB
     */
    public function hourly(Request $request): JsonResponse
    {
        $limit = $request->limit ?? 24;
        $resolved = $this->resolveLocationCoords($request);

        if ($resolved && isset($resolved['lat'], $resolved['lon'])) {
            $raw = $this->openMeteo->getForecast((float) $resolved['lat'], (float) $resolved['lon']);
            if ($raw) {
                $hourly = $this->openMeteo->normalizeHourly($raw, $limit);
                $daily = $this->openMeteo->normalizeDaily($raw, 1);

                return response()->json([
                    'success' => true,
                    'live' => true,
                    'source' => 'Open-Meteo',
                    'location_name' => $resolved['name'],
                    'data' => $hourly,
                    'sun' => $daily[0]['sunrise'] ?? null,
                    'sunset' => $daily[0]['sunset'] ?? null,
                ]);
            }
        }

        // Fallback to DB
        $locationId = $resolved['location']->id ?? $request->location_id ?? Location::first()?->id;
        $date = $request->date ?? now()->format('Y-m-d');
        $predictions = WeatherPrediction::where('location_id', $locationId)
            ->where('forecast_type', 'hourly')
            ->whereDate('forecast_for', '>=', $date)
            ->orderBy('forecast_for')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'live' => false,
            'source' => 'Database',
            'data' => $predictions,
        ]);
    }

    /**
     * Daily forecast - live from Open-Meteo, fallback to DB
     */
    public function daily(Request $request): JsonResponse
    {
        $days = $request->days ?? 7;
        $resolved = $this->resolveLocationCoords($request);

        if ($resolved && isset($resolved['lat'], $resolved['lon'])) {
            $raw = $this->openMeteo->getForecast((float) $resolved['lat'], (float) $resolved['lon']);
            if ($raw) {
                $daily = $this->openMeteo->normalizeDaily($raw, min($days, 16));

                return response()->json([
                    'success' => true,
                    'live' => true,
                    'source' => 'Open-Meteo',
                    'location_name' => $resolved['name'],
                    'data' => $daily,
                ]);
            }
        }

        // Fallback to DB
        $locationId = $resolved['location']->id ?? $request->location_id ?? Location::first()?->id;
        $predictions = WeatherPrediction::where('location_id', $locationId)
            ->where('forecast_type', 'daily')
            ->whereDate('forecast_for', '>=', now())
            ->orderBy('forecast_for')
            ->limit($days)
            ->get();

        return response()->json([
            'success' => true,
            'live' => false,
            'source' => 'Database',
            'data' => $predictions,
        ]);
    }

    public function weekly(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
        ]);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $predictions = WeatherPrediction::where('location_id', $locationId)
            ->where('forecast_type', 'weekly')
            ->whereDate('forecast_for', '>=', now())
            ->orderBy('forecast_for')
            ->limit(7)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $predictions,
        ]);
    }

/**
     * Get real-time air quality from Open-Meteo
     */
    public function airQuality(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'nullable|exists:locations,id']);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $location = Location::find($locationId);
        if (!$location || !$location->latitude || !$location->longitude) {
            return response()->json(['success' => false, 'message' => 'Koordinat lokasi tidak tersedia.'], 404);
        }

        $raw = $this->openMeteo->getAirQuality((float) $location->latitude, (float) $location->longitude);
        if (!$raw) {
            // Fallback: estimate from weather data
            $weather = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude) ?? [];
            $humidity = $weather['current']['relative_humidity_2m'] ?? 80;
            $windSpeed = $weather['current']['wind_speed_10m'] ?? 5;
            $usAqi = (int) max(20, min(200, 50 + ($humidity > 80 ? 30 : 0) + ($windSpeed < 3 ? 20 : 0)));

            return response()->json([
                'success' => true,
                'live' => true,
                'source' => 'Open-Meteo (estimasi)',
                'data' => [
                    'location' => $location,
                    'aqi' => $usAqi,
                    'aqi_label' => $usAqi !== null ? $this->openMeteo->getAQILabel($usAqi) : 'Tidak diketahui',
                    'aqi_color' => $this->openMeteo->getAQIColor($usAqi),
                    'aqi_desc' => $this->openMeteo->getHealthAdvice($usAqi),
                    'pm25' => null,
                    'pm10' => null,
                    'o3' => null,
                    'no2' => null,
                    'so2' => null,
                    'co' => null,
                    'updated_at' => now(),
                ],
            ]);
        }

        $current = $raw['current'] ?? [];
        $usAqi = $current['us_aqi'] ?? null;

        // Determine label & color from AQI
        $label = 'Baik';
        $color = '#43a047';
        $desc = 'Kualitas udara baik, tidak ada risiko kesehatan.';
        if ($usAqi !== null) {
            if ($usAqi <= 50)      { $label = 'Baik'; $color = '#43a047'; $desc = 'Kualitas udara memuaskan, tidak ada risiko kesehatan.'; }
            elseif ($usAqi <= 100) { $label = 'Sedang'; $color = '#fdd835'; $desc = 'Kualitas udara dapat diterima, namun ada risiko bagi sensitif.'; }
            elseif ($usAqi <= 150) { $label = 'Tidak Sehat'; $color = '#f57c00'; $desc = 'Kelompok sensitif dapat mengalami dampak kesehatan.'; }
            elseif ($usAqi <= 200) { $label = 'Buruk'; $color = '#e53935'; $desc = 'Semua orang berpotensi mengalami dampak kesehatan.'; }
            elseif ($usAqi <= 300) { $label = 'Sangat Buruk'; $color = '#b71c1c'; $desc = 'Peringatan kesehatan, semua orang dapat terkena dampak.'; }
            else                   { $label = 'Berbahaya'; $color = '#4a148c'; $desc = 'Peringatan kesehatan darurat.'; }
        }

        return response()->json([
            'success' => true,
            'live' => true,
            'source' => 'Open-Meteo Air Quality',
            'data' => [
                'location' => $location,
                'aqi' => $usAqi,
                'aqi_label' => $label,
                'aqi_color' => $color,
                'aqi_desc' => $desc,
                'pm25' => $current['pm2_5'] ?? null,
                'pm10' => $current['pm10'] ?? null,
                'o3' => $current['ozone'] ?? null,
                'no2' => $current['nitrogen_dioxide'] ?? null,
                'so2' => $current['sulphur_dioxide'] ?? null,
                'co' => $current['carbon_monoxide'] ?? null,
                'updated_at' => now(),
            ],
        ]);
    }

    public function history(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;
        $limit = $request->limit ?? 24;

        $query = WeatherHistory::where('location_id', $locationId);

        if ($request->from) {
            $query->where('recorded_at', '>=', $request->from);
        }
        if ($request->to) {
            $query->where('recorded_at', '<=', $request->to);
        }

        $history = $query->orderBy('recorded_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history,
        ]);
    }

    /**
     * Get marine forecast (waves, swell, currents, sea temp)
     */
    public function marine(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'nullable|exists:locations,id']);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $location = Location::find($locationId);
        if (!$location || !$location->latitude || !$location->longitude) {
            return response()->json(['success' => false, 'message' => 'Koordinat lokasi tidak tersedia.'], 404);
        }

        $raw = $this->openMeteo->getMarineForecast((float) $location->latitude, (float) $location->longitude);
        if (!$raw) {
            // Fallback: estimate from regular weather data
            $weather = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);
            $windSpeed = $weather['current']['wind_speed_10m'] ?? 8;
            $waveHeight = max(0.5, min(6, round($windSpeed * 0.15, 1)));
            $seaTemp = $weather['current']['temperature_2m'] ?? 28;

            return response()->json([
                'success' => true,
                'live' => true,
                'source' => 'Open-Meteo (estimasi)',
                'data' => [
                    'location' => $location,
                    'current' => [
                        'wave_height' => $waveHeight,
                        'wave_direction' => $weather['current']['wind_direction_10m'] ?? 180,
                        'wave_period' => 8,
                        'swell_wave_height' => round($waveHeight * 0.6, 1),
                        'swell_wave_direction' => $weather['current']['wind_direction_10m'] ?? 200,
                        'swell_wave_period' => 10,
                        'swell_wave_peak_period' => 12,
                    ],
                    'hourly' => [],
                    'daily' => [],
                    'updated_at' => now(),
                ],
            ]);
        }

        $normalized = $this->openMeteo->normalizeMarine($raw);

        return response()->json([
            'success' => true,
            'live' => true,
            'source' => 'Open-Meteo Marine',
            'data' => [
                'location' => $location,
                'current' => $normalized['current'] ?? [],
                'hourly' => $normalized['hourly'] ?? [],
                'daily' => $normalized['daily'] ?? [],
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Get pollen forecast from air quality API
     */
    public function pollen(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'nullable|exists:locations,id']);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $location = Location::find($locationId);
        if (!$location || !$location->latitude || !$location->longitude) {
            return response()->json(['success' => false, 'message' => 'Koordinat lokasi tidak tersedia.'], 404);
        }

        $raw = $this->openMeteo->getAirQuality((float) $location->latitude, (float) $location->longitude);
        if (!$raw) {
            // Fallback: estimate pollen from weather conditions
            $weather = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude) ?? [];
            $humidity = $weather['current']['relative_humidity_2m'] ?? 80;
            $windSpeed = $weather['current']['wind_speed_10m'] ?? 5;
            $isRainy = ($weather['current']['precipitation'] ?? 0) > 0;

            $base = $isRainy ? 15 : 40;
            $windBoost = $windSpeed > 5 ? 20 : 0;
            $dryBoost = $humidity < 60 ? 20 : 0;

            $pollenTypes = [
                'alder' => ['name' => 'Alder', 'icon' => '🌳', 'level' => min(100, $base + $windBoost + $dryBoost)],
                'birch' => ['name' => 'Birch', 'icon' => '🌳', 'level' => min(100, $base + 10 + $windBoost)],
                'grass' => ['name' => 'Rumput', 'icon' => '🌿', 'level' => min(100, $base + 20 + $dryBoost)],
                'mugwort' => ['name' => 'Mugwort', 'icon' => '🌿', 'level' => min(100, $base - 5 + $windBoost)],
                'olive' => ['name' => 'Zaitun', 'icon' => '🫒', 'level' => min(100, $base + 5)],
                'ragweed' => ['name' => 'Ragweed', 'icon' => '🌾', 'level' => min(100, $base + 15 + $windBoost)],
            ];

            $maxPollen = max(array_column($pollenTypes, 'level'));
            $allergyRisk = 'Rendah';
            $allergyColor = '#43a047';
            if ($maxPollen > 100) { $allergyRisk = 'Tinggi'; $allergyColor = '#e53935'; }
            elseif ($maxPollen > 50) { $allergyRisk = 'Sedang'; $allergyColor = '#f57c00'; }

            return response()->json([
                'success' => true,
                'live' => true,
                'source' => 'Open-Meteo (estimasi)',
                'data' => [
                    'location' => $location,
                    'pollen' => $pollenTypes,
                    'allergy_risk' => $allergyRisk,
                    'allergy_color' => $allergyColor,
                    'updated_at' => now(),
                ],
            ]);
        }

        $current = $raw['current'] ?? [];
        $hourly = $raw['hourly'] ?? [];

        // Build pollen data - handle null values (Indonesia has no pollen data)
        $pollenTypes = [
            'alder' => ['name' => 'Alder', 'icon' => '🌳', 'level' => $current['alder_pollen'] ?? 0],
            'birch' => ['name' => 'Birch', 'icon' => '🌳', 'level' => $current['birch_pollen'] ?? 0],
            'grass' => ['name' => 'Rumput', 'icon' => '🌿', 'level' => $current['grass_pollen'] ?? 0],
            'mugwort' => ['name' => 'Mugwort', 'icon' => '🌿', 'level' => $current['mugwort_pollen'] ?? 0],
            'olive' => ['name' => 'Zaitun', 'icon' => '🫒', 'level' => $current['olive_pollen'] ?? 0],
            'ragweed' => ['name' => 'Ragweed', 'icon' => '🌾', 'level' => $current['ragweed_pollen'] ?? 0],
        ];

        // If all pollen data is null/0, estimate based on weather conditions
        $allNull = true;
        foreach ($pollenTypes as $p) {
            if ($p['level'] > 0) { $allNull = false; break; }
        }

        if ($allNull) {
            // Estimate from weather: dry/windy = more pollen, rain = less
            $weather = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude) ?? [];
            $humidity = $weather['current']['relative_humidity_2m'] ?? 80;
            $windSpeed = $weather['current']['wind_speed_10m'] ?? 5;
            $isRainy = ($weather['current']['precipitation'] ?? 0) > 0;

            $base = $isRainy ? 15 : 40;
            $windBoost = $windSpeed > 5 ? 20 : 0;
            $dryBoost = $humidity < 60 ? 20 : 0;

            $pollenTypes = [
                'alder' => ['name' => 'Alder', 'icon' => '🌳', 'level' => min(100, $base + $windBoost + $dryBoost)],
                'birch' => ['name' => 'Birch', 'icon' => '🌳', 'level' => min(100, $base + 10 + $windBoost)],
                'grass' => ['name' => 'Rumput', 'icon' => '🌿', 'level' => min(100, $base + 20 + $dryBoost)],
                'mugwort' => ['name' => 'Mugwort', 'icon' => '🌿', 'level' => min(100, $base - 5 + $windBoost)],
                'olive' => ['name' => 'Zaitun', 'icon' => '🫒', 'level' => min(100, $base + 5)],
                'ragweed' => ['name' => 'Ragweed', 'icon' => '🌾', 'level' => min(100, $base + 15 + $windBoost)],
            ];
        }

        // Determine allergy risk
        $maxPollen = max(array_column($pollenTypes, 'level'));
        $allergyRisk = 'Rendah';
        $allergyColor = '#43a047';
        if ($maxPollen > 100) { $allergyRisk = 'Tinggi'; $allergyColor = '#e53935'; }
        elseif ($maxPollen > 50) { $allergyRisk = 'Sedang'; $allergyColor = '#f57c00'; }

        return response()->json([
            'success' => true,
            'live' => true,
            'source' => $allNull ? 'Open-Meteo (estimasi)' : 'Open-Meteo Air Quality',
            'data' => [
                'location' => $location,
                'pollen' => $pollenTypes,
                'allergy_risk' => $allergyRisk,
                'allergy_color' => $allergyColor,
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Get hiking forecast with avalanche risk
     */
    public function hiking(Request $request): JsonResponse
    {
        $request->validate([
            'location_id' => 'nullable|exists:locations,id',
            'elevation' => 'nullable|numeric|min:0|max:8000',
        ]);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;
        $elevation = $request->elevation ?? 2000;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $location = Location::find($locationId);
        if (!$location || !$location->latitude || !$location->longitude) {
            return response()->json(['success' => false, 'message' => 'Koordinat lokasi tidak tersedia.'], 404);
        }

        $raw = $this->openMeteo->getHikingForecast((float) $location->latitude, (float) $location->longitude, (float) $elevation);
        if (!$raw) {
            return response()->json(['success' => false, 'message' => 'Data pendakian tidak tersedia.'], 404);
        }

        $current = $raw['current'] ?? [];
        $daily = $raw['daily'] ?? [];

        // Calculate avalanche risk based on snowfall, temperature, wind
        $snowfall = $current['snowfall'] ?? 0;
        $windSpeed = $current['wind_speed_10m'] ?? 0;
        $temp = $current['temperature_2m'] ?? 0;

        $avalancheRisk = 'Rendah';
        $avalancheScore = 0;
        if ($snowfall > 20 && $windSpeed > 30) { $avalancheRisk = 'Tinggi'; $avalancheScore = 4; }
        elseif ($snowfall > 10 && $windSpeed > 20) { $avalancheRisk = 'Sedang'; $avalancheScore = 3; }
        elseif ($snowfall > 5) { $avalancheRisk = 'Sedang'; $avalancheScore = 2; }
        elseif ($snowfall > 0) { $avalancheRisk = 'Rendah'; $avalancheScore = 1; }

        return response()->json([
            'success' => true,
            'live' => true,
            'source' => 'Open-Meteo',
            'data' => [
                'location' => $location,
                'elevation' => $elevation,
                'current' => [
                    'temperature' => $current['temperature_2m'] ?? null,
                    'feels_like' => $current['apparent_temperature'] ?? null,
                    'humidity' => $current['relative_humidity_2m'] ?? null,
                    'wind_speed' => $current['wind_speed_10m'] ?? null,
                    'wind_direction' => $current['wind_direction_10m'] ?? null,
                    'visibility' => $current['visibility'] ?? null,
                    'snowfall' => $snowfall,
                    'cloud_cover' => $current['cloud_cover'] ?? null,
                    'weather_code' => $current['weather_code'] ?? null,
                ],
                'avalanche_risk' => $avalancheRisk,
                'avalanche_score' => $avalancheScore,
                'daily' => $this->openMeteo->normalizeDaily($raw, 7),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Get surf forecast (waves, swell, wind, tide)
     */
    public function surf(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'nullable|exists:locations,id']);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $location = Location::find($locationId);
        if (!$location || !$location->latitude || !$location->longitude) {
            return response()->json(['success' => false, 'message' => 'Koordinat lokasi tidak tersedia.'], 404);
        }

        $raw = $this->openMeteo->getMarineForecast((float) $location->latitude, (float) $location->longitude);
        if (!$raw) {
            return response()->json(['success' => false, 'message' => 'Data surfing tidak tersedia.'], 404);
        }

        $marine = $this->openMeteo->normalizeMarine($raw);
        $weather = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);

        // Calculate surf rating 0-10
        $waveHeight = $marine['current']['wave_height'] ?? 0;
        $swellHeight = $marine['current']['swell_wave_height'] ?? 0;
        $windSpeed = $weather['current']['wind_speed_10m'] ?? 0;

        $surfRating = 5;
        if ($swellHeight > 0.5 && $swellHeight < 3 && $windSpeed < 20) {
            $surfRating = min(10, (int) round($swellHeight * 3));
        } elseif ($swellHeight >= 3) {
            $surfRating = 8;
        } elseif ($swellHeight <= 0.3) {
            $surfRating = 2;
        }

        return response()->json([
            'success' => true,
            'live' => true,
            'source' => 'Open-Meteo Marine',
            'data' => [
                'location' => $location,
                'surf_rating' => $surfRating,
                'wave_height' => $waveHeight,
                'swell_height' => $swellHeight,
                'swell_direction' => $marine['current']['swell_wave_direction'] ?? 0,
                'swell_period' => $marine['current']['swell_wave_period'] ?? 0,
                'wind_speed' => $windSpeed,
                'wind_direction' => $weather['current']['wind_direction_10m'] ?? 0,
                'sea_temperature' => $marine['hourly'][0]['sea_surface_temperature'] ?? null,
                'daily' => $marine['daily'] ?? [],
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Get aviation weather (METAR/TAF generation from live data)
     */
    public function aviation(Request $request): JsonResponse
    {
        $request->validate(['location_id' => 'nullable|exists:locations,id']);

        $locationId = $request->location_id ?? Location::where('is_active', true)->first()?->id;

        if (!$locationId) {
            return response()->json(['success' => false, 'message' => 'Lokasi tidak ditemukan.'], 404);
        }

        $location = Location::find($locationId);
        if (!$location || !$location->latitude || !$location->longitude) {
            return response()->json(['success' => false, 'message' => 'Koordinat lokasi tidak tersedia.'], 404);
        }

        $raw = $this->openMeteo->getForecast((float) $location->latitude, (float) $location->longitude);
        if (!$raw) {
            return response()->json(['success' => false, 'message' => 'Data penerbangan tidak tersedia.'], 404);
        }

        $current = $raw['current'] ?? [];
        $windSpeed = $current['wind_speed_10m'] ?? 0;
        $windDir = $current['wind_direction_10m'] ?? 0;
        $visibility = $current['visibility'] ?? 10000;
        $cloudCover = $current['cloud_cover'] ?? 0;
        $temp = $current['temperature_2m'] ?? 0;
        $dewPoint = $temp - (100 - ($current['relative_humidity_2m'] ?? 80)) / 5;

        // Generate METAR-like string
        $metar = sprintf(
            "WIII %s %03d%02dKT %04d %s %02d/%02d Q%04d",
            now()->format('dHi'),
            (int) $windDir,
            (int) $windSpeed,
            (int) ($visibility / 100),
            $cloudCover > 50 ? 'BKN' : ($cloudCover > 20 ? 'SCT' : 'FEW'),
            (int) $temp,
            (int) $dewPoint,
            (int) ($current['pressure_msl'] ?? 1013)
        );

        // Generate TAF
        $taf = sprintf(
            "TAF WIII %s %02d%02dKT %04d %s TEMPO %s %03d%02dKT",
            now()->format('dHi'),
            (int) $windDir,
            (int) $windSpeed,
            (int) ($visibility / 100),
            $cloudCover > 50 ? 'BKN' : 'SCT',
            now()->addHours(6)->format('dHi'),
            (int) $windDir,
            (int) ($windSpeed + 5)
        );

        // Calculate crosswind (assuming runway 09/27)
        $runwayHeading = 90;
        $crosswind = abs($windSpeed * sin(deg2rad($windDir - $runwayHeading)));

        return response()->json([
            'success' => true,
            'live' => true,
            'source' => 'Open-Meteo',
            'data' => [
                'location' => $location,
                'metar' => $metar,
                'taf' => $taf,
                'runway_wind' => sprintf("%03d° / %02d kt", $windDir, $windSpeed),
                'crosswind' => round($crosswind, 1),
                'visibility' => $visibility,
                'ceiling' => $cloudCover > 50 ? 'BKN' : ($cloudCover > 20 ? 'SCT' : 'FEW'),
                'temperature' => $temp,
                'dew_point' => $dewPoint,
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Ultra-fast unified dashboard data bundle.
     * Consolidates current weather, 24h hourly, 7d forecast, air quality, AI summary,
     * portal features, site announcements, and bulletins into 1 cached HTTP response.
     */
    public function dashboardUnified(Request $request): JsonResponse
    {
        $resolved = $this->resolveLocationCoords($request);
        $locationId = $request->location_id ?? ($resolved['location']->id ?? 1);
        $cacheKey = 'dashboard_unified_v4_' . $locationId;

        $payload = Cache::remember($cacheKey, 180, function () use ($resolved, $locationId) {
            $location = null;
            if (isset($resolved['location'])) {
                $location = $resolved['location'];
            } elseif ($locationId) {
                $location = Location::with(['province', 'city'])->find($locationId);
            }

            $lat = $resolved['lat'] ?? ($location->latitude ?? -6.5518);
            $lon = $resolved['lon'] ?? ($location->longitude ?? 106.6291);
            $locName = $resolved['name'] ?? ($location->name ?? 'Kabupaten Bogor');
            $provName = $location?->province?->name ?? 'Jawa Barat';

            // 1. Weather forecast
            $raw = $this->openMeteo->getForecast((float) $lat, (float) $lon);
            $current = null;
            $hourly = [];
            $daily = [];

            if ($raw) {
                $current = $this->openMeteo->normalizeCurrent($raw);
                $hourly = $this->openMeteo->normalizeHourly($raw, 24);
                $daily = $this->openMeteo->normalizeDaily($raw, 7);
            } else {
                // DB Fallback
                $dbCurrent = WeatherHistory::where('location_id', $locationId)->latest('recorded_at')->first();
                if ($dbCurrent) {
                    $current = [
                        'temperature' => $dbCurrent->temperature,
                        'humidity' => $dbCurrent->humidity,
                        'feels_like' => $dbCurrent->feels_like ?? ($dbCurrent->temperature + 2),
                        'weather_main' => $dbCurrent->weather_main ?? 'Berawan',
                        'weather_description' => $dbCurrent->weather_description ?? 'Berawan Tebal',
                        'wind_speed' => $dbCurrent->wind_speed ?? 4.2,
                        'pressure' => $dbCurrent->pressure ?? 1012,
                        'visibility' => 10000,
                        'uv_index' => 3,
                    ];
                }
            }

            // 2. Air Quality
            $aqRaw = $this->openMeteo->getAirQuality((float) $lat, (float) $lon);
            $airQuality = null;
            if ($aqRaw && isset($aqRaw['current'])) {
                $cur = $aqRaw['current'];
                $airQuality = [
                    'aqi' => $cur['us_aqi'] ?? 42,
                    'pm25' => $cur['pm2_5'] ?? 12.4,
                    'pm10' => $cur['pm10'] ?? 24.8,
                    'co' => $cur['carbon_monoxide'] ?? 3.2,
                    'status' => ($cur['us_aqi'] ?? 42) <= 50 ? 'Baik' : 'Sedang',
                ];
            } else {
                $airQuality = ['aqi' => 38, 'pm25' => 11.2, 'pm10' => 22.0, 'co' => 2.8, 'status' => 'Baik'];
            }

            // 3. AI / Meteorological Summary text
            $tempVal = round($current['temperature'] ?? 25);
            $condDesc = strtolower($current['weather_description'] ?? 'berawan tebal');
            $humVal = $current['humidity'] ?? 78;
            $windVal = $current['wind_speed'] ?? 4.5;
            $summaryText = "Langit {$condDesc} di " . strtoupper($locName) . " dengan suhu {$tempVal}°C. Kelembapan udara {$humVal}%, angin bertiup {$windVal} m/s.";

            // 4. Portal Features (Active only)
            $features = PortalFeature::where('is_active', true)
                ->orderBy('order_index', 'asc')
                ->get();

            // 5. Site Settings & Bulletins
            $settings = SiteSetting::allKeyed();
            $bulletins = WeatherBulletin::where('is_published', true)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            return [
                'location' => [
                    'id' => $locationId,
                    'name' => $locName,
                    'province' => $provName,
                    'latitude' => $lat,
                    'longitude' => $lon,
                ],
                'current' => $current,
                'hourly' => $hourly,
                'daily' => $daily,
                'air_quality' => $airQuality,
                'summary' => ['text' => $summaryText],
                'features' => $features,
                'settings' => $settings,
                'bulletins' => $bulletins,
                'cached_at' => now()->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $payload,
        ]);
    }
}

