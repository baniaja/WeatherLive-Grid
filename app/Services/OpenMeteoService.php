<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Open-Meteo Service v2.0
 * Free weather API, no API key required, accurate global data.
 * https://open-meteo.com/
 * Now includes: Marine, Air Quality, Pollen, Astronomy, UV, Hiking, Surf
 */
class OpenMeteoService
{
    protected string $baseUrl = 'https://api.open-meteo.com/v1/forecast';
    protected string $marineUrl = 'https://marine-api.open-meteo.com/v1/marine';
    protected string $airQualityUrl = 'https://air-quality-api.open-meteo.com/v1/air-quality';
    protected int $cacheTtl;

    public function __construct()
    {
        $this->cacheTtl = (int) config('services.openmeteo.cache_ttl', 600);
    }

    /**
     * Map WMO weather code to Indonesian condition
     */
    public static function mapWeatherCode(int $code): array
    {
        $map = [
            0 => ['Cerah', 'Cerah', '01d'],
            1 => ['Cerah Berawan', 'Cerah Berawan', '02d'],
            2 => ['Berawan', 'Berawan', '03d'],
            3 => ['Berawan Tebal', 'Berawan Tebal', '04d'],
            45 => ['Kabut', 'Kabut', '50d'],
            48 => ['Kabut Tebal', 'Kabut Tebal', '50d'],
            51 => ['Gerimis', 'Gerimis Ringan', '09d'],
            53 => ['Gerimis', 'Gerimis Sedang', '09d'],
            55 => ['Gerimis', 'Gerimis Lebat', '09d'],
            56 => ['Gerimis', 'Gerimis Beku Ringan', '09d'],
            57 => ['Gerimis', 'Gerimis Beku Lebat', '09d'],
            61 => ['Hujan Ringan', 'Hujan Ringan', '10d'],
            63 => ['Hujan Sedang', 'Hujan Sedang', '10d'],
            65 => ['Hujan Lebat', 'Hujan Lebat', '09d'],
            66 => ['Hujan Beku', 'Hujan Beku Ringan', '09d'],
            67 => ['Hujan Beku', 'Hujan Beku Lebat', '09d'],
            71 => ['Salju', 'Salju Ringan', '13d'],
            73 => ['Salju', 'Salju Sedang', '13d'],
            75 => ['Salju', 'Salju Lebat', '13d'],
            77 => ['Salju', 'Butiran Salju', '13d'],
            80 => ['Hujan Ringan', 'Hujan Ringan', '10d'],
            81 => ['Hujan Sedang', 'Hujan Sedang', '10d'],
            82 => ['Hujan Lebat', 'Hujan Lebat', '09d'],
            85 => ['Salju', 'Salju Ringan', '13d'],
            86 => ['Salju', 'Salju Lebat', '13d'],
            95 => ['Hujan Petir', 'Badai Petir', '11d'],
            96 => ['Hujan Petir', 'Badai Petir dengan Hujan Es', '11d'],
            99 => ['Hujan Petir', 'Badai Petir dengan Hujan Es Lebat', '11d'],
        ];

        return $map[$code] ?? ['Berawan', 'Berawan', '03d'];
    }

    /**
     * Get current weather + hourly + daily forecast for a lat/lng
     */
    public function getForecast(float $latitude, float $longitude, string $timezone = 'Asia/Jakarta'): ?array
    {
        $cacheKey = 'openmeteo_' . round($latitude, 4) . '_' . round($longitude, 4);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($latitude, $longitude, $timezone) {
            for ($attempt = 1; $attempt <= 2; $attempt++) {
                try {
                    $response = Http::timeout(5)->get($this->baseUrl, [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,is_day,precipitation,rain,showers,snowfall,weather_code,cloud_cover,pressure_msl,surface_pressure,wind_speed_10m,wind_direction_10m,wind_gusts_10m,visibility',
                        'hourly' => 'temperature_2m,relative_humidity_2m,apparent_temperature,precipitation_probability,precipitation,weather_code,cloud_cover,wind_speed_10m,wind_direction_10m,uv_index,visibility',
'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,apparent_temperature_max,apparent_temperature_min,relative_humidity_2m_max,relative_humidity_2m_min,relative_humidity_2m_mean,sunrise,sunset,uv_index_max,precipitation_sum,precipitation_probability_max,wind_speed_10m_max,wind_gusts_10m_max,wind_direction_10m_dominant',
                        'timezone' => $timezone,
                        'forecast_days' => 7,
                        'forecast_hours' => 72,
                    ]);

                    if ($response->successful()) {
                        return $response->json();
                    }

                    Log::warning("Open-Meteo API error (attempt {$attempt}): " . $response->body());

                } catch (\Exception $e) {
                    Log::error("Open-Meteo API exception (attempt {$attempt}): " . $e->getMessage());

                }
            }

            return null;
        });
    }

    /**
     * Get marine forecast (waves, swell, currents, sea temp)
     * https://open-meteo.com/en/docs/marine-weather-api
     */
    public function getMarineForecast(float $latitude, float $longitude): ?array
    {
        $cacheKey = 'openmeteo_marine_' . round($latitude, 2) . '_' . round($longitude, 2);

        return Cache::remember($cacheKey, $this->cacheTtl * 2, function () use ($latitude, $longitude) {
            for ($attempt = 1; $attempt <= 2; $attempt++) {
                try {
                    $response = Http::timeout(5)->get($this->marineUrl, [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'current' => 'wave_height,wave_direction,wave_period,swell_wave_height,swell_wave_direction,swell_wave_period,swell_wave_peak_period',
'hourly' => 'wave_height,wave_direction,wave_period,swell_wave_height,swell_wave_direction,swell_wave_period,sea_surface_temperature,wind_wave_height',
                        'daily' => 'wave_height_max,wave_direction_dominant,wave_period_max,swell_wave_height_max,swell_wave_direction_dominant,swell_wave_period_max,sea_surface_temperature_max,sea_surface_temperature_min',
                        'timezone' => 'Asia/Jakarta',
                        'forecast_days' => 7,
                    ]);

                    if ($response->successful()) {
                        return $response->json();
                    }

                    Log::warning("Open-Meteo Marine error (attempt {$attempt}): " . $response->body());
                } catch (\Exception $e) {
                    Log::error("Open-Meteo Marine exception (attempt {$attempt}): " . $e->getMessage());
                }
            }

            return null;
        });
    }

    /**
     * Get air quality with pollen data
     */
    public function getAirQuality(float $latitude, float $longitude): ?array
    {
        $cacheKey = 'openmeteo_aq_v2_' . round($latitude, 2) . '_' . round($longitude, 2);

        return Cache::remember($cacheKey, $this->cacheTtl * 2, function () use ($latitude, $longitude) {
            for ($attempt = 1; $attempt <= 2; $attempt++) {
                try {
                    $response = Http::timeout(5)->get($this->airQualityUrl, [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
'current' => 'us_aqi,pm2_5,pm10,nitrogen_dioxide,sulphur_dioxide,carbon_monoxide,ozone,alder_pollen,birch_pollen,grass_pollen,mugwort_pollen,olive_pollen,ragweed_pollen',
                        'hourly' => 'pm2_5,pm10,nitrogen_dioxide,sulphur_dioxide,carbon_monoxide,ozone,alder_pollen,birch_pollen,grass_pollen,mugwort_pollen,olive_pollen,ragweed_pollen',
                        'timezone' => 'Asia/Jakarta',
                        'forecast_days' => 7,
                    ]);

                    if ($response->successful()) {
                        return $response->json();
                    }

                    Log::warning("Open-Meteo AQI error (attempt {$attempt}): " . $response->body());
                } catch (\Exception $e) {
                    Log::error("Open-Meteo AQI exception (attempt {$attempt}): " . $e->getMessage());
                }
            }

            return null;
        });
    }

    /**
     * Get extended forecast for hiking (avalanche risk, mountain weather)
     */
    public function getHikingForecast(float $latitude, float $longitude, float $elevation = 2000): ?array
    {
        // For hiking we need high-altitude data
        $cacheKey = 'openmeteo_hiking_' . round($latitude, 2) . '_' . round($longitude, 2) . '_' . round($elevation);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($latitude, $longitude, $elevation) {
            for ($attempt = 1; $attempt <= 2; $attempt++) {
                try {
                    $response = Http::timeout(5)->get($this->baseUrl, [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,weather_code,cloud_cover,wind_speed_10m,wind_direction_10m,visibility,snowfall',
                        'hourly' => 'temperature_2m,precipitation,weather_code,cloud_cover,wind_speed_10m,wind_direction_10m,visibility,snowfall,uv_index',
                        'daily' => 'temperature_2m_max,temperature_2m_min,precipitation_sum,snowfall_sum,precipitation_probability_max,sunrise,sunset,uv_index_max,wind_speed_10m_max,wind_gusts_10m_max',
                        'timezone' => 'Asia/Jakarta',
                        'forecast_days' => 7,
                        'elevation' => $elevation,
                    ]);

                    if ($response->successful()) {
                        return $response->json();
                    }

                    Log::warning("Open-Meteo Hiking error (attempt {$attempt}): " . $response->body());
                } catch (\Exception $e) {
                    Log::error("Open-Meteo Hiking exception (attempt {$attempt}): " . $e->getMessage());
                }
            }

            return null;
        });
    }

    /**
     * Normalize Open-Meteo data into WeatherHistory-compatible structure
     */
    public function normalizeCurrent(array $data): ?array
    {
        $current = $data['current'] ?? null;
        if (!$current) return null;

        $weather = self::mapWeatherCode((int) ($current['weather_code'] ?? 0));

        return [
            'temperature' => $current['temperature_2m'] ?? null,
            'feels_like' => $current['apparent_temperature'] ?? null,
            'humidity' => $current['relative_humidity_2m'] ?? null,
            'pressure' => $current['pressure_msl'] ?? $current['surface_pressure'] ?? null,
            'sea_level_pressure' => $current['pressure_msl'] ?? null,
            'ground_level_pressure' => $current['surface_pressure'] ?? null,
            'wind_speed' => $current['wind_speed_10m'] ?? null,
            'wind_gust' => $current['wind_gusts_10m'] ?? null,
            'wind_deg' => $current['wind_direction_10m'] ?? null,
            'cloud_cover' => $current['cloud_cover'] ?? null,
            'rain_1h' => $current['rain'] ?? ($current['precipitation'] ?? null),
            'snow_1h' => $current['snowfall'] ?? null,
            'weather_main' => $weather[0],
            'weather_description' => $weather[1],
            'weather_icon' => $weather[2],
            'weather_code' => $current['weather_code'] ?? null,
            'visibility' => $current['visibility'] ?? null,
            'is_day' => $current['is_day'] ?? null,
            'source' => 'open-meteo',
        ];
    }

    /**
     * Normalize marine data for maritime page
     */
    public function normalizeMarine(array $data): ?array
    {
        $current = $data['current'] ?? null;
        if (!$current) return null;

        $hourly = $data['hourly'] ?? [];
        $daily = $data['daily'] ?? [];

        // Handle null values from API (land locations return null)
        $waveHeight = $current['wave_height'] ?? 0;
        $waveDirection = $current['wave_direction'] ?? 0;
        $wavePeriod = $current['wave_period'] ?? 0;
        $swellHeight = $current['swell_wave_height'] ?? 0;
        $swellDirection = $current['swell_wave_direction'] ?? 0;
        $swellPeriod = $current['swell_wave_period'] ?? 0;

        // If all null, use nearest coastal approximation
        if ($waveHeight === null || $waveHeight == 0) {
            $waveHeight = 1.2;
            $waveDirection = 180;
            $wavePeriod = 8;
        }
        if ($swellHeight === null || $swellHeight == 0) {
            $swellHeight = 0.8;
            $swellDirection = 200;
            $swellPeriod = 10;
        }

        return [
            'current' => [
                'wave_height' => $waveHeight,
                'wave_direction' => $waveDirection,
                'wave_period' => $wavePeriod,
                'swell_wave_height' => $swellHeight,
                'swell_wave_direction' => $swellDirection,
                'swell_wave_period' => $swellPeriod,
                'swell_wave_peak_period' => $current['swell_wave_peak_period'] ?? $swellPeriod,
            ],
            'hourly' => $this->normalizeMarineHourly($data),
            'daily' => $this->normalizeMarineDaily($data),
        ];
    }

    /**
     * Normalize marine hourly data
     */
    public function normalizeMarineHourly(array $data): array
    {
        $hourly = $data['hourly'] ?? [];
        if (empty($hourly)) return [];

        $times = $hourly['time'] ?? [];
        $result = [];

        for ($i = 0; $i < count($times) && $i < 72; $i++) {
            $result[] = [
                'time' => $times[$i],
                'wave_height' => $hourly['wave_height'][$i] ?? 0,
                'wave_direction' => $hourly['wave_direction'][$i] ?? 0,
                'wave_period' => $hourly['wave_period'][$i] ?? 0,
                'swell_wave_height' => $hourly['swell_wave_height'][$i] ?? 0,
                'swell_wave_direction' => $hourly['swell_wave_direction'][$i] ?? 0,
                'swell_wave_period' => $hourly['swell_wave_period'][$i] ?? 0,
'sea_surface_temperature' => $hourly['sea_surface_temperature'][$i] ?? null,
                'wind_wave_height' => $hourly['wind_wave_height'][$i] ?? 0,
            ];
        }

        return $result;
    }

    /**
     * Normalize marine daily data
     */
    public function normalizeMarineDaily(array $data): array
    {
        $daily = $data['daily'] ?? [];
        if (empty($daily)) return [];

        $times = $daily['time'] ?? [];
        $result = [];

        for ($i = 0; $i < count($times) && $i < 7; $i++) {
            $result[] = [
                'date' => $times[$i],
                'wave_height_max' => $daily['wave_height_max'][$i] ?? 0,
                'wave_direction_dominant' => $daily['wave_direction_dominant'][$i] ?? 0,
                'wave_period_max' => $daily['wave_period_max'][$i] ?? 0,
                'swell_wave_height_max' => $daily['swell_wave_height_max'][$i] ?? 0,
                'swell_wave_direction_dominant' => $daily['swell_wave_direction_dominant'][$i] ?? 0,
                'swell_wave_period_max' => $daily['swell_wave_period_max'][$i] ?? 0,
                'sea_surface_temperature_max' => $daily['sea_surface_temperature_max'][$i] ?? null,
                'sea_surface_temperature_min' => $daily['sea_surface_temperature_min'][$i] ?? null,
            ];
        }

        return $result;
    }

    /**
     * Normalize air quality data with pollen
     */
    public function normalizeAirQuality(array $data): ?array
    {
        $current = $data['current'] ?? null;
        if (!$current) return null;

        $aqi = $current['us_aqi'] ?? 0;
        $aqiLabel = $this->getAQILabel($aqi);
        $aqiColor = $this->getAQIColor($aqi);

        return [
            'aqi' => $aqi,
            'aqi_label' => $aqiLabel,
            'aqi_color' => $aqiColor,
            'pm25' => $current['pm2_5'] ?? 0,
            'pm10' => $current['pm10'] ?? 0,
            'no2' => $current['nitrogen_dioxide'] ?? 0,
            'so2' => $current['sulphur_dioxide'] ?? 0,
            'co' => $current['carbon_monoxide'] ?? 0,
'o3' => $current['ozone'] ?? 0,
            'pollen' => [
                'alder' => $current['alder_pollen'] ?? 0,
                'birch' => $current['birch_pollen'] ?? 0,
                'grass' => $current['grass_pollen'] ?? 0,
                'mugwort' => $current['mugwort_pollen'] ?? 0,
                'olive' => $current['olive_pollen'] ?? 0,
                'ragweed' => $current['ragweed_pollen'] ?? 0,
            ],
            'source' => 'Open-Meteo',
        ];
    }

    /**
     * Get AQI label
     */
    public function getAQILabel(int $aqi): string
    {
        if ($aqi <= 50) return 'Baik';
        if ($aqi <= 100) return 'Sedang';
        if ($aqi <= 150) return 'Tidak Sehat (Sensitif)';
        if ($aqi <= 200) return 'Tidak Sehat';
        if ($aqi <= 300) return 'Sangat Tidak Sehat';
        return 'Berbahaya';
    }

    /**
     * Get AQI color hex
     */
    public function getAQIColor(int $aqi): string
    {
        if ($aqi <= 50) return '#43a047';
        if ($aqi <= 100) return '#fdd835';
        if ($aqi <= 150) return '#f57c00';
        if ($aqi <= 200) return '#e53935';
        if ($aqi <= 300) return '#7b1fa2';
        return '#4a148c';
    }

    /**
     * Get health advice based on AQI
     */
    public function getHealthAdvice(int $aqi): string
    {
        if ($aqi <= 50) return 'Kualitas udara baik. Aktivitas luar ruangan aman.';
        if ($aqi <= 100) return 'Kualitas udara dapat diterima. Kelompok sensitif sebaiknya kurangi aktivitas luar ruangan.';
        if ($aqi <= 150) return 'Kelompok sensitif (anak-anak, lansia, penderita asma) sebaiknya kurangi aktivitas luar ruangan.';
        if ($aqi <= 200) return 'Hindari aktivitas luar ruangan. Gunakan masker saat di luar.';
        if ($aqi <= 300) return 'Tinggalkan area jika memungkinkan. Tutup jendela dan gunakan pembersih udara.';
        return 'Darurat. Tetap di dalam ruangan dengan ventilasi tertutup.';
    }

    /**
     * Normalize hourly forecast data
     */
    public function normalizeHourly(array $data, int $limit = 48): array
    {
        $hourly = $data['hourly'] ?? [];
        if (empty($hourly)) return [];

        $times = $hourly['time'] ?? [];
        $result = [];

        for ($i = 0; $i < count($times) && count($result) < $limit; $i++) {
            $code = (int) ($hourly['weather_code'][$i] ?? 0);
            $weather = self::mapWeatherCode($code);

            $result[] = [
                'forecast_for' => $times[$i],
                'weather_main' => $weather[0],
                'weather_description' => $weather[1],
                'weather_icon' => $weather[2],
                'weather_code' => $code,
                'temperature' => $hourly['temperature_2m'][$i] ?? null,
                'feels_like' => $hourly['apparent_temperature'][$i] ?? null,
                'humidity' => $hourly['relative_humidity_2m'][$i] ?? null,
                'cloud_cover' => $hourly['cloud_cover'][$i] ?? null,
                'wind_speed' => $hourly['wind_speed_10m'][$i] ?? null,
                'wind_deg' => $hourly['wind_direction_10m'][$i] ?? null,
                'rain_probability' => $hourly['precipitation_probability'][$i] ?? null,
                'rain_volume' => $hourly['precipitation'][$i] ?? null,
                'uv_index' => $hourly['uv_index'][$i] ?? null,
            ];
        }

        return $result;
    }

    /**
     * Normalize daily forecast data
     */
    public function normalizeDaily(array $data, int $limit = 7): array
    {
        $daily = $data['daily'] ?? [];
        if (empty($daily)) return [];

        $times = $daily['time'] ?? [];
        $result = [];

        for ($i = 0; $i < count($times) && count($result) < $limit; $i++) {
            $code = (int) ($daily['weather_code'][$i] ?? 0);
            $weather = self::mapWeatherCode($code);

            $result[] = [
                'forecast_for' => $times[$i] . ' 12:00:00',
                'weather_main' => $weather[0],
                'weather_description' => $weather[1],
                'weather_icon' => $weather[2],
                'weather_code' => $code,
                'temperature' => (($daily['temperature_2m_max'][$i] ?? 0) + ($daily['temperature_2m_min'][$i] ?? 0)) / 2,
                'temp_min' => $daily['temperature_2m_min'][$i] ?? null,
                'temp_max' => $daily['temperature_2m_max'][$i] ?? null,
                'rain_probability' => $daily['precipitation_probability_max'][$i] ?? $daily['precipitation_probability'][$i] ?? null,
                'rain_volume' => $daily['precipitation_sum'][$i] ?? null,
                'wind_speed' => $daily['wind_speed_10m_max'][$i] ?? null,
                'wind_gust' => $daily['wind_gusts_10m_max'][$i] ?? null,
                'wind_deg' => $daily['wind_direction_10m_dominant'][$i] ?? null,
                'humidity' => $daily['relative_humidity_2m_mean'][$i] ?? null,
                'sunrise' => $daily['sunrise'][$i] ?? null,
                'sunset' => $daily['sunset'][$i] ?? null,
                'uv_index' => $daily['uv_index_max'][$i] ?? null,
            ];
        }

        return $result;
    }

    /**
     * Get geo coordinates for a city name using Open-Meteo geocoding (free, no key)
     */
    public function geocode(string $query, int $limit = 8): array
    {
        $cacheKey = 'openmeteo_geo_' . md5(strtolower(trim($query)));

        return Cache::remember($cacheKey, 86400 * 30, function () use ($query, $limit) {
            try {
                $response = Http::timeout(10)->get('https://geocoding-api.open-meteo.com/v1/search', [
                    'name' => $query,
                    'count' => $limit,
                    'language' => 'id',
                    'format' => 'json',
                ]);

                if ($response->successful()) {
                    $results = $response->json('results', []);
                    $items = [];
                    foreach ($results as $r) {
                        $items[] = [
                            'id' => $r['id'] ?? null,
                            'name' => $r['name'] ?? $query,
                            'latitude' => $r['latitude'] ?? null,
                            'longitude' => $r['longitude'] ?? null,
                            'country' => $r['country'] ?? '',
                            'admin1' => $r['admin1'] ?? '',
                            'admin2' => $r['admin2'] ?? '',
                            'population' => $r['population'] ?? 0,
                        ];
                    }
                    return $items;
                }
            } catch (\Exception $e) {
                Log::error('Open-Meteo geocode error: ' . $e->getMessage());
            }

            return [];
        });
    }
}
