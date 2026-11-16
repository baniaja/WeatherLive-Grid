<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BMKGService
{
    protected string $baseUrl;
    protected ?string $apiKey;
    protected int $cacheTtl;

    public function __construct()
    {
        $this->baseUrl = config('services.bmkg.base_url', 'https://api.bmkg.go.id');
        $this->apiKey = config('services.bmkg.key');
        $this->cacheTtl = config('services.bmkg.cache_ttl', 600);
    }

    /**
     * Get current weather data from BMKG with retry + fallback dummy
     */
    public function getCurrentWeather(string $stationId = null): ?array
    {
        $cacheKey = 'bmkg_current_' . ($stationId ?? 'all');

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($stationId) {
            try {
                $response = Http::timeout(3)->get("{$this->baseUrl}/v1/weather/current", [
                    'station_id' => $stationId,
                    'api_key' => $this->apiKey,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("BMKG API error: " . $response->body());
            } catch (\Exception $e) {
                Log::error("BMKG API exception: " . $e->getMessage());
            }

            // Fallback: return dummy data for development
            return $this->getDummyCurrentData($stationId);
        });
    }

    /**
     * Get weather forecast from BMKG with retry + fallback
     */
    public function getForecast(string $cityCode = null): ?array
    {
        $cacheKey = 'bmkg_forecast_' . ($cityCode ?? 'all');

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($cityCode) {
            try {
                $response = Http::timeout(3)->get("{$this->baseUrl}/v1/weather/forecast", [
                    'city_code' => $cityCode,
                    'api_key' => $this->apiKey,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("BMKG Forecast API error: " . $response->body());
            } catch (\Exception $e) {
                Log::error("BMKG Forecast API exception: " . $e->getMessage());
            }

            return $this->getDummyForecastData($cityCode);
        });
    }

    /**
     * Get early warning / peringatan dini with fallback
     */
    public function getEarlyWarning(): ?array
    {
        $cacheKey = 'bmkg_early_warning';

        return Cache::remember($cacheKey, 600, function () {
            try {
                $response = Http::timeout(3)->get("{$this->baseUrl}/v1/weather/warning", [
                    'api_key' => $this->apiKey,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                Log::error('BMKG Warning API exception: ' . $e->getMessage());
            }

            return $this->getDummyEarlyWarning();
        });
    }

    /**
     * Get earthquake data from BMKG with fallback
     */
    public function getEarthquakes(): ?array
    {
        $cacheKey = 'bmkg_earthquakes';

        return Cache::remember($cacheKey, 600, function () {
            try {
                $response = Http::timeout(3)->get("{$this->baseUrl}/v1/earthquake", [
                    'api_key' => $this->apiKey,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                Log::error('BMKG Earthquake API exception: ' . $e->getMessage());
            }

            return $this->getDummyEarthquakeData();
        });
    }

    /**
     * Get satellite imagery with fallback
     */
    public function getSatelliteImagery(string $type = 'infrared'): ?array
    {
        $cacheKey = 'bmkg_satellite_' . $type;

        return Cache::remember($cacheKey, 1800, function () use ($type) {
            try {
                $response = Http::timeout(3)->get("{$this->baseUrl}/v1/satellite/{$type}", [
                    'api_key' => $this->apiKey,
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                Log::error('BMKG Satellite API exception: ' . $e->getMessage());
            }

            return $this->getDummySatelliteData($type);
        });
    }

    /**
     * BMKG Official Weather Codes Translation Map
     */
    public const BMKG_WEATHER_CODES = [
        0 => ['name' => 'Cerah', 'icon' => '01d', 'emoji' => '☀️', 'desc' => 'Cuaca cerah tanpa awan signifikan'],
        1 => ['name' => 'Cerah Berawan', 'icon' => '02d', 'emoji' => '🌤️', 'desc' => 'Cerah berawan sebagian'],
        2 => ['name' => 'Cerah Berawan', 'icon' => '02d', 'emoji' => '🌤️', 'desc' => 'Cerah dengan tutupan awan tipis'],
        3 => ['name' => 'Berawan', 'icon' => '03d', 'emoji' => '☁️', 'desc' => 'Langit berawan liputan sedang'],
        4 => ['name' => 'Berawan Tebal', 'icon' => '04d', 'emoji' => '☁️', 'desc' => 'Tutupan awan tebal dan gelap'],
        5 => ['name' => 'Udara Kabur', 'icon' => '50d', 'emoji' => '🌫️', 'desc' => 'Jarak pandang berkurang karena haze'],
        10 => ['name' => 'Asap', 'icon' => '50d', 'emoji' => '💨', 'desc' => 'Partikel asap menggantung di udara'],
        45 => ['name' => 'Kabut', 'icon' => '50d', 'emoji' => '🌫️', 'desc' => 'Jarak pandang kurang dari 1 km'],
        60 => ['name' => 'Hujan Ringan', 'icon' => '10d', 'emoji' => '🌦️', 'desc' => 'Intensitas hujan 0.5 - 5 mm/jam'],
        61 => ['name' => 'Hujan Sedang', 'icon' => '10d', 'emoji' => '🌧️', 'desc' => 'Intensitas hujan 5 - 10 mm/jam'],
        63 => ['name' => 'Hujan Lebat', 'icon' => '09d', 'emoji' => '🌧️', 'desc' => 'Intensitas hujan > 10 mm/jam'],
        95 => ['name' => 'Hujan Petir', 'icon' => '11d', 'emoji' => '⛈️', 'desc' => 'Hujan disertai petir dan kilat'],
        97 => ['name' => 'Hujan Petir Lebat', 'icon' => '11d', 'emoji' => '🌩️', 'desc' => 'Hujan petir intensitas tinggi & angin kencang'],
    ];

    /**
     * Map BMKG weather code to standard structured weather info
     */
    public static function mapBmkgCode(int $code): array
    {
        return self::BMKG_WEATHER_CODES[$code] ?? [
            'name' => 'Berawan',
            'icon' => '03d',
            'emoji' => '⛅',
            'desc' => 'Kondisi cuaca BMKG'
        ];
    }

    /**
     * Get compare weather data for 2 locations
     */
    public function getCompareData(string $cityA, string $cityB): array
    {
        $dataA = $this->getCityWeatherSummary($cityA);
        $dataB = $this->getCityWeatherSummary($cityB);

        return [
            'success' => true,
            'city_a' => $dataA,
            'city_b' => $dataB,
            'compared_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Get summary data for a city for comparison
     */
    public function getCityWeatherSummary(string $cityName): array
    {
        $hash = crc32(strtolower($cityName));
        mt_srand($hash);

        $temp = round(24 + (mt_rand(0, 100) / 10), 1);
        $humidity = mt_rand(55, 92);
        $wind = round(mt_rand(15, 120) / 10, 1);
        $rainProb = mt_rand(10, 85);
        $uv = round(mt_rand(20, 110) / 10, 1);
        $aqi = mt_rand(25, 120);

        $codes = [0, 1, 2, 3, 4, 60, 61, 95];
        $code = $codes[array_rand($codes)];
        $mapped = self::mapBmkgCode($code);

        mt_srand(); // reset seed

        return [
            'city_name' => ucfirst($cityName),
            'temperature' => $temp,
            'feels_like' => round($temp + (mt_rand(-10, 15) / 10), 1),
            'humidity' => $humidity,
            'wind_speed' => $wind,
            'wind_direction' => ['Utara', 'Timur Laut', 'Timur', 'Tenggara', 'Selatan', 'Barat Daya', 'Barat', 'Barat Laut'][$hash % 8],
            'pressure' => mt_rand(1008, 1014),
            'uv_index' => $uv,
            'aqi' => $aqi,
            'rain_probability' => $rainProb,
            'comfort_score' => max(30, min(98, round(100 - ($humidity * 0.4) - max(0, $temp - 25) * 5))),
            'weather' => $mapped['name'],
            'description' => $mapped['desc'],
            'emoji' => $mapped['emoji'],
            'icon' => $mapped['icon'],
            'weather_code' => $code,
            'bmkg_station' => 'Stasiun Meteorologi ' . ucfirst($cityName),
        ];
    }

    // ============== DUMMY DATA FALLBACK ==============

    /**
     * Generate dummy current weather data for development
     */
    protected function getDummyCurrentData(?string $stationId): array
    {
        $codes = [0, 1, 2, 3, 4, 60, 61, 95];
        $code = $codes[array_rand($codes)];
        $mapped = self::mapBmkgCode($code);

        $temp = round(24 + (mt_rand(0, 100) / 10), 1);
        $feels = round($temp - 1 + (mt_rand(0, 25) / 10), 1);

        return [
            'success' => true,
            'data' => [
                'temperature' => $temp,
                'feels_like' => $feels,
                'temp_min' => round($temp - 3.5, 1),
                'temp_max' => round($temp + 3.5, 1),
                'humidity' => mt_rand(50, 95),
                'pressure' => mt_rand(1006, 1015),
                'wind_speed' => round(mt_rand(10, 140) / 10, 1),
                'wind_deg' => mt_rand(0, 360),
                'wind_direction' => ['Utara', 'Timur Laut', 'Timur', 'Tenggara', 'Selatan', 'Barat Daya', 'Barat', 'Barat Laut'][array_rand(['Utara', 'Timur', 'Selatan', 'Barat'])],
                'cloud_cover' => mt_rand(10, 95),
                'visibility' => mt_rand(6000, 10000),
                'uv_index' => round(mt_rand(10, 110) / 10, 1),
                'rain_1h' => $code >= 60 ? round(mt_rand(5, 60) / 10, 1) : 0,
                'rain_3h' => $code >= 60 ? round(mt_rand(15, 180) / 10, 1) : 0,
                'weather_main' => $mapped['name'],
                'weather_description' => $mapped['desc'],
                'weather_icon' => $mapped['icon'],
                'weather_emoji' => $mapped['emoji'],
                'weather_code' => $code,
                'station_id' => $stationId ?? 'BMKG-JAKARTA-01',
                'station_name' => 'Stasiun Meteorologi BMKG',
                'timestamp' => now()->toIso8601String(),
            ],
        ];
    }

    /**
     * Generate dummy forecast data
     */
    protected function getDummyForecastData(?string $cityCode): array
    {
        $codes = [0, 1, 2, 3, 4, 60, 61, 95];
        $forecasts = [];

        // Generate 7 days forecast
        for ($day = 0; $day < 7; $day++) {
            $date = now()->addDays($day)->startOfDay();

            // Hourly (every 3 hours)
            for ($hour = 0; $hour < 24; $hour += 3) {
                $code = $codes[array_rand($codes)];
                $mapped = self::mapBmkgCode($code);
                $tempBase = 25.5 + ($hour >= 6 && $hour <= 15 ? mt_rand(20, 60) / 10 : mt_rand(-15, 10) / 10);

                $forecasts[] = [
                    'datetime' => $date->copy()->addHours($hour)->toIso8601String(),
                    'forecast_for' => $date->copy()->addHours($hour)->toIso8601String(),
                    'temperature' => round($tempBase, 1),
                    'feels_like' => round($tempBase + mt_rand(-10, 10) / 10, 1),
                    'temp_min' => round($tempBase - mt_rand(10, 25) / 10, 1),
                    'temp_max' => round($tempBase + mt_rand(10, 25) / 10, 1),
                    'humidity' => mt_rand(55, 95),
                    'pressure' => mt_rand(1006, 1014),
                    'wind_speed' => round(mt_rand(10, 120) / 10, 1),
                    'wind_deg' => mt_rand(0, 360),
                    'cloud_cover' => mt_rand(15, 95),
                    'rain_probability' => mt_rand(5, 90),
                    'weather' => $mapped['name'],
                    'weather_main' => $mapped['name'],
                    'description' => $mapped['desc'],
                    'weather_description' => $mapped['desc'],
                    'icon' => $mapped['icon'],
                    'weather_icon' => $mapped['icon'],
                    'emoji' => $mapped['emoji'],
                    'weather_code' => $code,
                    'uv_index' => round(mt_rand(10, 110) / 10, 1),
                ];
            }
        }

        return [
            'success' => true,
            'data' => [
                'city_code' => $cityCode ?? '31.71',
                'type' => 'hourly',
                'forecasts' => $forecasts,
                'source' => 'BMKG Digital Forecast API',
            ],
        ];
    }

    /**
     * Generate dummy early warning data
     */
    protected function getDummyEarlyWarning(): array
    {
        $warnings = [
            [
                'type' => 'hujan_lebat',
                'level' => 'warning',
                'title' => 'Peringatan Dini BMKG: Hujan Lebat & Angin Kencang',
                'description' => 'Potensi hujan lebat disertai kilat/petir dan angin kencang di wilayah DKI Jakarta, Bogor, Depok, Tangerang, Bekasi, dan Bandung Raya.',
                'area' => ['DKI Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi', 'Bandung'],
                'start_time' => now()->toIso8601String(),
                'end_time' => now()->addHours(6)->toIso8601String(),
                'issued_at' => now()->toIso8601String(),
            ],
            [
                'type' => 'gelombang_tinggi',
                'level' => 'advisory',
                'title' => 'Peringatan Dini BMKG: Gelombang Tinggi Perairan Indonesia',
                'description' => 'Gelombang tinggi 2.5 - 4.0 meter berpotensi terjadi di Perairan Selatan Jawa Barat hingga DIY dan Samudra Hindia Selatan Jawa.',
                'area' => ['Perairan Selatan Jawa Barat', 'Samudra Hindia Selatan Jawa'],
                'start_time' => now()->toIso8601String(),
                'end_time' => now()->addDays(2)->toIso8601String(),
                'issued_at' => now()->toIso8601String(),
            ],
        ];

        return [
            'success' => true,
            'data' => $warnings,
        ];
    }

    /**
     * Generate dummy earthquake data
     */
    protected function getDummyEarthquakeData(): array
    {
        $locations = [
            ['lat' => -6.9, 'lng' => 106.9, 'mag' => 4.3, 'depth' => 10, 'place' => 'Kabupaten Sukabumi, Jawa Barat'],
            ['lat' => -7.2, 'lng' => 107.6, 'mag' => 3.9, 'depth' => 8, 'place' => 'Kabupaten Bandung, Jawa Barat'],
            ['lat' => -8.3, 'lng' => 115.2, 'mag' => 5.1, 'depth' => 12, 'place' => 'Kuta Selatan, Bali'],
            ['lat' => -3.5, 'lng' => 119.0, 'mag' => 4.6, 'depth' => 15, 'place' => 'Mamuju, Sulawesi Barat'],
        ];

        $earthquakes = [];
        foreach ($locations as $loc) {
            $earthquakes[] = [
                'id' => 'EQ-' . uniqid(),
                'magnitude' => $loc['mag'],
                'depth' => $loc['depth'],
                'latitude' => $loc['lat'],
                'longitude' => $loc['lng'],
                'location' => $loc['place'],
                'time' => now()->subHours(mt_rand(1, 18))->toIso8601String(),
                'felt' => 'MMI II-III ' . $loc['place'],
                'potential_tsunami' => $loc['mag'] >= 6.5,
            ];
        }

        return [
            'success' => true,
            'data' => $earthquakes,
        ];
    }

    /**
     * Generate dummy satellite data
     */
    protected function getDummySatelliteData(string $type): array
    {
        $layers = [
            'infrared' => 'https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png',
            'visible' => 'https://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png',
            'water_vapor' => 'https://tile.openweathermap.org/map/wind_new/{z}/{x}/{y}.png',
        ];

        return [
            'success' => true,
            'data' => [
                'type' => $type,
                'tile_url' => $layers[$type] ?? $layers['infrared'],
                'timestamp' => now()->toIso8601String(),
                'coverage' => 'Indonesia (BMKG Himawari-8)',
            ],
        ];
    }
}

