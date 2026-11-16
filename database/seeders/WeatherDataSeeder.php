<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\WeatherHistory;
use App\Models\WeatherPrediction;
use App\Models\WeatherActual;
use App\Models\WeatherAccuracy;
use App\Models\WeatherAlert;
use App\Models\AirQuality;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WeatherDataSeeder extends Seeder
{
    private $weatherConditions = [
        'Cerah', 'Cerah Berawan', 'Berawan', 'Berawan Tebal',
        'Hujan Ringan', 'Hujan Sedang', 'Hujan Lebat', 'Hujan Petir',
        'Kabut', 'Kabut Tebal', 'Angin Kencang',
    ];

    private $weatherDescs = [
        'Cerah' => 'Cerah',
        'Cerah Berawan' => 'Cerah Berawan',
        'Berawan' => 'Berawan',
        'Berawan Tebal' => 'Berawan Tebal',
        'Hujan Ringan' => 'Hujan Ringan',
        'Hujan Sedang' => 'Hujan Sedang',
        'Hujan Lebat' => 'Hujan Lebat',
        'Hujan Petir' => 'Hujan Disertai Petir',
        'Kabut' => 'Kabut',
        'Kabut Tebal' => 'Kabut Tebal',
        'Angin Kencang' => 'Angin Kencang',
    ];

    private $weatherIcons = [
        'Cerah' => '01d',
        'Cerah Berawan' => '02d',
        'Berawan' => '03d',
        'Berawan Tebal' => '04d',
        'Hujan Ringan' => '10d',
        'Hujan Sedang' => '10d',
        'Hujan Lebat' => '09d',
        'Hujan Petir' => '11d',
        'Kabut' => '50d',
        'Kabut Tebal' => '50d',
        'Angin Kencang' => '50d',
    ];

    public function run(): void
    {
        $locations = Location::where('is_active', true)->get();
        $now = Carbon::now();
        $this->command->info("Seeding weather data for " . count($locations) . " locations...");

        foreach ($locations as $location) {
            // Determine base temperature based on location
            $baseTemp = $this->getBaseTemperature($location);
            $this->seedHistory($location, $baseTemp, $now);
            $this->seedPredictions($location, $baseTemp, $now);
            $this->seedActuals($location, $baseTemp, $now);
            $this->seedAirQuality($location, $now);
        }

        $this->seedAlerts($locations);
        $this->seedAccuracy($now);

        $this->command->info('Weather data seeded successfully for all locations!');
    }

    private function getBaseTemperature($location): float
    {
        // Determine base temp by latitude/region
        $lat = $location->latitude ?? -6.9;
        $region = $location->province?->name ?? '';

        if (str_contains($region, 'Jawa Barat') || str_contains($region, 'DKI Jakarta') || str_contains($region, 'Banten')) {
            return round(26 + (floatval($lat) + 6) * 0.5, 1); // 26-30°C
        } elseif (str_contains($region, 'Jawa Tengah') || str_contains($region, 'DI Yogyakarta')) {
            return round(25 + (floatval($lat) + 7) * 0.4, 1); // 25-28°C
        } elseif (str_contains($region, 'Jawa Timur') || str_contains($region, 'Bali')) {
            return round(27 + (floatval($lat) + 8) * 0.3, 1); // 27-30°C
        } elseif (str_contains($region, 'Sumatera')) {
            return round(27 + (floatval($lat) - 2) * 0.3, 1); // 27-31°C
        } elseif (str_contains($region, 'Kalimantan')) {
            return round(28 + (floatval($lat) - 1) * 0.4, 1); // 28-32°C
        } elseif (str_contains($region, 'Sulawesi')) {
            return 27.5 + (abs(floatval($lat)) - 2) * 0.3; // 27-30°C
        } elseif (str_contains($region, 'Papua')) {
            return 27 + (abs(floatval($lat)) - 3) * 0.3; // 27-30°C
        } elseif (str_contains($region, 'Nusa')) {
            return 28 + (abs(floatval($lat)) - 8) * 0.4; // 28-32°C
        } else {
            return 27.5; // default
        }
    }

    private function getRandomWeather(): array
    {
        $idx = array_rand($this->weatherConditions);
        $main = $this->weatherConditions[$idx];
        return [
            'main' => $main,
            'desc' => $this->weatherDescs[$main],
            'icon' => $this->weatherIcons[$main],
        ];
    }

    private function seedHistory($location, float $baseTemp, Carbon $now): void
    {
        // Seed 7 days of hourly history
        for ($day = 6; $day >= 0; $day--) {
            for ($hour = 0; $hour < 24; $hour += 3) {
                $date = $now->copy()->subDays($day)->setTime($hour, 0, 0);
                $weather = $this->getRandomWeather();

                $hourFactor = ($hour >= 6 && $hour <= 15) ? 1.0 : -1.0;
                $temp = $baseTemp + (($hour - 12) * 0.3) * $hourFactor + (mt_rand(-10, 10) / 10);

                $windSpeed = round(mt_rand(5, 80) / 10, 1);
                $windDeg = mt_rand(0, 360);
                $directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];

                WeatherHistory::create([
                    'location_id' => $location->id,
                    'recorded_at' => $date,
                    'temperature' => round($temp, 1),
                    'feels_like' => round($temp - 1 + (mt_rand(-5, 10) / 10), 1),
                    'temp_min' => round($temp - 2 - (mt_rand(0, 20) / 10), 1),
                    'temp_max' => round($temp + 2 + (mt_rand(0, 20) / 10), 1),
                    'humidity' => mt_rand(45, 95),
                    'pressure' => mt_rand(1005, 1018),
                    'sea_level_pressure' => mt_rand(1008, 1022),
                    'ground_level_pressure' => mt_rand(1000, 1015),
                    'wind_speed' => $windSpeed,
                    'wind_gust' => round($windSpeed * 1.3 + (mt_rand(0, 20) / 10), 1),
                    'wind_deg' => $windDeg,
                    'wind_direction' => $directions[floor($windDeg / 45) % 8],
                    'cloud_cover' => mt_rand(0, 100),
                    'visibility' => mt_rand(3000, 10000),
                    'uv_index' => $hour >= 6 && $hour <= 16 ? round(mt_rand(0, 110) / 10, 1) : 0,
                    'rain_1h' => in_array($weather['main'], ['Hujan Ringan', 'Hujan Sedang', 'Hujan Lebat', 'Hujan Petir'])
                        ? round(mt_rand(5, 150) / 10, 1) : 0,
                    'rain_3h' => in_array($weather['main'], ['Hujan Ringan', 'Hujan Sedang', 'Hujan Lebat', 'Hujan Petir'])
                        ? round(mt_rand(15, 400) / 10, 1) : 0,
                    'weather_main' => $weather['main'],
                    'weather_description' => $weather['desc'],
                    'weather_icon' => $weather['icon'],
                    'weather_code' => array_search($weather['main'], $this->weatherConditions) + 1,
                    'dew_point' => round($temp - (100 - mt_rand(45, 95)) / 5, 1),
                    'heat_index' => round($temp + (mt_rand(45, 95) - 70) / 10, 1),
                    'source' => 'bmkg',
                ]);
            }
        }
    }

    private function seedPredictions($location, float $baseTemp, Carbon $now): void
    {
        // Hourly predictions for next 48 hours
        for ($hour = 0; $hour < 48; $hour++) {
            $forecastFor = $now->copy()->addHours($hour);
            $weather = $this->getRandomWeather();
            $temp = $baseTemp + (($forecastFor->hour - 12) * 0.3) + (mt_rand(-10, 10) / 10);

            WeatherPrediction::create([
                'location_id' => $location->id,
                'forecast_for' => $forecastFor,
                'issued_at' => $now,
                'weather_main' => $weather['main'],
                'weather_description' => $weather['desc'],
                'weather_icon' => $weather['icon'],
                'temperature' => round($temp, 1),
                'feels_like' => round($temp - 1 + (mt_rand(-5, 10) / 10), 1),
                'temp_min' => round($temp - 2 - (mt_rand(0, 20) / 10), 1),
                'temp_max' => round($temp + 2 + (mt_rand(0, 20) / 10), 1),
                'humidity' => mt_rand(45, 95),
                'pressure' => mt_rand(1005, 1018),
                'wind_speed' => round(mt_rand(5, 80) / 10, 1),
                'wind_deg' => mt_rand(0, 360),
                'wind_gust' => round(mt_rand(10, 120) / 10, 1),
                'cloud_cover' => mt_rand(0, 100),
                'visibility' => mt_rand(3000, 10000),
                'uv_index' => $forecastFor->hour >= 6 && $forecastFor->hour <= 16 ? round(mt_rand(0, 110) / 10, 1) : 0,
                'rain_probability' => in_array($weather['main'], ['Hujan Ringan', 'Hujan Sedang', 'Hujan Lebat', 'Hujan Petir'])
                    ? mt_rand(30, 95) : mt_rand(0, 20),
                'rain_volume' => in_array($weather['main'], ['Hujan Ringan', 'Hujan Sedang', 'Hujan Lebat', 'Hujan Petir'])
                    ? round(mt_rand(5, 150) / 10, 1) : 0,
                'source' => 'bmkg',
                'forecast_type' => 'hourly',
            ]);
        }

        // Daily predictions for next 7 days
        for ($day = 0; $day < 7; $day++) {
            $forecastFor = $now->copy()->addDays($day)->startOfDay()->addHours(12);
            $weather = $this->getRandomWeather();
            $temp = $baseTemp + (mt_rand(-20, 20) / 10);

            WeatherPrediction::create([
                'location_id' => $location->id,
                'forecast_for' => $forecastFor,
                'issued_at' => $now,
                'weather_main' => $weather['main'],
                'weather_description' => $weather['desc'],
                'weather_icon' => $weather['icon'],
                'temperature' => round($temp, 1),
                'feels_like' => round($temp - 1 + (mt_rand(-5, 10) / 10), 1),
                'temp_min' => round($temp - 4 - (mt_rand(0, 30) / 10), 1),
                'temp_max' => round($temp + 4 + (mt_rand(0, 30) / 10), 1),
                'humidity' => mt_rand(45, 95),
                'pressure' => mt_rand(1005, 1018),
                'wind_speed' => round(mt_rand(5, 80) / 10, 1),
                'wind_deg' => mt_rand(0, 360),
                'cloud_cover' => mt_rand(0, 100),
                'rain_probability' => in_array($weather['main'], ['Hujan Ringan', 'Hujan Sedang', 'Hujan Lebat', 'Hujan Petir'])
                    ? mt_rand(30, 95) : mt_rand(0, 20),
                'source' => 'bmkg',
                'forecast_type' => 'daily',
            ]);
        }
    }

    private function seedActuals($location, float $baseTemp, Carbon $now): void
    {
        // Seed actuals for the past 3 days
        for ($day = 2; $day >= 0; $day--) {
            for ($hour = 0; $hour < 24; $hour += 3) {
                $date = $now->copy()->subDays($day)->setTime($hour, 0, 0);
                $weather = $this->getRandomWeather();
                $temp = $baseTemp + (($hour - 12) * 0.3) + (mt_rand(-10, 10) / 10);

                WeatherActual::create([
                    'location_id' => $location->id,
                    'observed_at' => $date,
                    'weather_main' => $weather['main'],
                    'weather_description' => $weather['desc'],
                    'weather_icon' => $weather['icon'],
                    'temperature' => round($temp, 1),
                    'feels_like' => round($temp - 1 + (mt_rand(-5, 10) / 10), 1),
                    'humidity' => mt_rand(45, 95),
                    'pressure' => mt_rand(1005, 1018),
                    'wind_speed' => round(mt_rand(5, 80) / 10, 1),
                    'wind_deg' => mt_rand(0, 360),
                    'cloud_cover' => mt_rand(0, 100),
                    'rain_1h' => in_array($weather['main'], ['Hujan Ringan', 'Hujan Sedang', 'Hujan Lebat', 'Hujan Petir'])
                        ? round(mt_rand(5, 150) / 10, 1) : 0,
                    'source' => 'bmkg',
                ]);
            }
        }
    }

    private function seedAirQuality($location, Carbon $now): void
    {
        // Seed AQI data for the past 3 days
        for ($day = 2; $day >= 0; $day--) {
            for ($hour = 0; $hour < 24; $hour += 6) {
                $date = $now->copy()->subDays($day)->setTime($hour, 0, 0);

                AirQuality::create([
                    'location_id' => $location->id,
                    'recorded_at' => $date,
                    'aqi' => mt_rand(15, 150),
                    'pm2_5' => round(mt_rand(50, 500) / 10, 1),
                    'pm10' => round(mt_rand(100, 800) / 10, 1),
                    'ozone' => round(mt_rand(10, 120) / 10, 1),
                    'nitrogen_dioxide' => round(mt_rand(5, 80) / 10, 1),
                    'sulphur_dioxide' => round(mt_rand(5, 50) / 10, 1),
                    'carbon_monoxide' => round(mt_rand(100, 500) / 100, 2),
                    'ammonia' => round(mt_rand(10, 60) / 10, 1),
                    'source' => 'bmkg',
                ]);
            }
        }
    }

    private function seedAlerts($locations): void
    {
        $alertConfigs = [
            [
                'title' => 'Peringatan Hujan Lebat',
                'description' => 'BMKG mengeluarkan peringatan dini hujan lebat yang dapat disertai petir dan angin kencang. Waspada potensi banjir di daerah rawan.',
                'alert_type' => 'heavy_rain',
                'severity' => 'danger',
                'location_filter' => ['Kabupaten Bogor', 'Kota Bogor', 'Kabupaten Bandung', 'Kota Bandung'],
            ],
            [
                'title' => 'Peringatan Gelombang Tinggi',
                'description' => 'Gelombang tinggi 2.5-4 meter berpotensi terjadi di perairan selatan Jawa Barat. Nelayan diminta waspada.',
                'alert_type' => 'high_wave',
                'severity' => 'warning',
                'location_filter' => ['Kabupaten Sukabumi', 'Kabupaten Garut', 'Kabupaten Tasikmalaya'],
            ],
            [
                'title' => 'Waspada Angin Kencang',
                'description' => 'Angin kencang dengan kecepatan 30-45 km/jam berpotensi terjadi di wilayah Jawa Barat bagian utara.',
                'alert_type' => 'strong_wind',
                'severity' => 'warning',
                'location_filter' => ['Kabupaten Indramayu', 'Kabupaten Cirebon', 'Kabupaten Subang'],
            ],
            [
                'title' => 'Potensi Banjir Rob',
                'description' => 'Wilayah pesisir utara Jawa Barat berpotensi mengalami banjir rob akibat naiknya permukaan air laut.',
                'alert_type' => 'flood',
                'severity' => 'info',
                'location_filter' => ['Kabupaten Bekasi', 'Kota Bekasi', 'Kabupaten Karawang'],
            ],
            [
                'title' => 'Cuaca Ekstrem Wilayah Jawa Barat',
                'description' => 'Peringatan cuaca ekstrem untuk wilayah Jawa Barat. Potensi hujan lebat disertai petir dan angin kencang pada sore hingga malam hari.',
                'alert_type' => 'extreme_weather',
                'severity' => 'danger',
                'location_filter' => null, // all locations
            ],
            [
                'title' => 'Kualitas Udara Tidak Sehat',
                'description' => 'Kualitas udara di beberapa wilayah perkotaan menunjukkan kategori tidak sehat bagi kelompok sensitif. Kurangi aktivitas luar ruangan.',
                'alert_type' => 'air_quality',
                'severity' => 'info',
                'location_filter' => ['Kota Bandung', 'Kota Bekasi', 'Kota Depok', 'Kota Bogor'],
            ],
        ];

        foreach ($alertConfigs as $config) {
            $targetLocations = $locations;
            if ($config['location_filter']) {
                $filteredNames = $config['location_filter'];
                $targetLocations = $locations->filter(function ($loc) use ($filteredNames) {
                    foreach ($filteredNames as $name) {
                        if (str_contains($loc->name, $name)) return true;
                    }
                    return false;
                });
            }

            foreach ($targetLocations as $location) {
                WeatherAlert::create([
                    'location_id' => $location->id,
                    'title' => $config['title'],
                    'description' => $config['description'],
                    'alert_type' => $config['alert_type'],
                    'severity' => $config['severity'],
                    'issued_at' => now()->subHours(mt_rand(0, 12)),
                    'effective_from' => now()->subHours(mt_rand(0, 6)),
                    'effective_until' => now()->addHours(mt_rand(12, 48)),
                    'source' => 'BMKG',
                    'status' => 'active',
                ]);
            }
        }
    }

    private function seedAccuracy(Carbon $now): void
    {
        // Create accuracy evaluations for past 7 days
        $locations = Location::where('is_active', true)->get();
        foreach ($locations as $location) {
            for ($day = 6; $day >= 0; $day--) {
                $date = $now->copy()->subDays($day);
                $predictions = WeatherPrediction::where('location_id', $location->id)
                    ->whereDate('forecast_for', $date)
                    ->get();

                foreach ($predictions as $prediction) {
                    $actual = WeatherActual::where('location_id', $location->id)
                        ->whereDate('observed_at', $prediction->forecast_for->toDateString())
                        ->first();

                    if (!$actual) continue;

                    $tempDiff = abs(($prediction->temperature ?? 0) - ($actual->temperature ?? 0));
                    $isCorrect = $tempDiff < 3;
                    $accuracyScore = max(0, 100 - ($tempDiff * 10));

                    WeatherAccuracy::create([
                        'location_id' => $location->id,
                        'prediction_id' => $prediction->id,
                        'actual_id' => $actual->id,
                        'evaluated_at' => $date->addHours(23)->addMinutes(59),
                        'temp_predicted' => $prediction->temperature ?? 0,
                        'temp_actual' => $actual->temperature ?? 0,
                        'temp_difference' => $tempDiff,
                        'weather_predicted' => $prediction->weather_main,
                        'weather_actual_condition' => $actual->weather_main,
                        'weather_match' => strtolower($prediction->weather_main ?? '') === strtolower($actual->weather_main ?? ''),
                        'humidity_predicted' => $prediction->humidity,
                        'humidity_actual' => $actual->humidity,
                        'humidity_difference' => abs(($prediction->humidity ?? 0) - ($actual->humidity ?? 0)),
                        'wind_speed_predicted' => $prediction->wind_speed,
                        'wind_speed_actual' => $actual->wind_speed,
                        'wind_speed_difference' => abs(($prediction->wind_speed ?? 0) - ($actual->wind_speed ?? 0)),
                        'pressure_predicted' => $prediction->pressure,
                        'pressure_actual' => $actual->pressure,
                        'pressure_difference' => abs(($prediction->pressure ?? 0) - ($actual->pressure ?? 0)),
                        'status' => $isCorrect ? 'correct' : 'incorrect',
                        'accuracy_score' => round($accuracyScore, 2),
                    ]);
                }
            }
        }
    }
}

