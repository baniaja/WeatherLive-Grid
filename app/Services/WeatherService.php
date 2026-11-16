<?php

namespace App\Services;

use App\Models\Location;
use App\Models\WeatherActual;
use App\Models\WeatherHistory;
use App\Models\WeatherPrediction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected BMKGService $bmkgService;

    public function __construct(BMKGService $bmkgService)
    {
        $this->bmkgService = $bmkgService;
    }

    /**
     * Fetch and store current weather data from BMKG
     */
    public function fetchCurrentWeather(): void
    {
        $locations = Location::where('is_active', true)->get();

        foreach ($locations as $location) {
            try {
                $data = $this->bmkgService->getCurrentWeather($location->bmkg_code);

                if ($data && isset($data['data'])) {
                    $this->storeWeatherData($location, $data['data']);
                }
            } catch (\Exception $e) {
                Log::error("Failed to fetch weather for {$location->name}: {$e->getMessage()}");
            }
        }
    }

    /**
     * Fetch and store forecast data
     */
    public function fetchForecast(): void
    {
        $locations = Location::where('is_active', true)->get();

        foreach ($locations as $location) {
            try {
                $data = $this->bmkgService->getForecast($location->bmkg_code);

                if ($data && isset($data['data'])) {
                    $this->storeForecastData($location, $data['data']);
                }
            } catch (\Exception $e) {
                Log::error("Failed to fetch forecast for {$location->name}: {$e->getMessage()}");
            }
        }
    }

    /**
     * Store weather data to history
     */
    protected function storeWeatherData(Location $location, array $data): void
    {
        $history = WeatherHistory::create([
            'location_id' => $location->id,
            'recorded_at' => now(),
            'temperature' => $data['temperature'] ?? null,
            'feels_like' => $data['feels_like'] ?? null,
            'temp_min' => $data['temp_min'] ?? null,
            'temp_max' => $data['temp_max'] ?? null,
            'humidity' => $data['humidity'] ?? null,
            'pressure' => $data['pressure'] ?? null,
            'wind_speed' => $data['wind_speed'] ?? null,
            'wind_deg' => $data['wind_deg'] ?? null,
            'wind_direction' => $data['wind_direction'] ?? null,
            'cloud_cover' => $data['cloud_cover'] ?? null,
            'visibility' => $data['visibility'] ?? null,
            'uv_index' => $data['uv_index'] ?? null,
            'rain_1h' => $data['rain_1h'] ?? null,
            'rain_3h' => $data['rain_3h'] ?? null,
            'weather_main' => $data['weather_main'] ?? null,
            'weather_description' => $data['weather_description'] ?? null,
            'weather_icon' => $data['weather_icon'] ?? null,
            'weather_code' => $data['weather_code'] ?? null,
            'source' => 'bmkg',
        ]);

        // Also update actual data
        WeatherActual::create([
            'location_id' => $location->id,
            'observed_at' => now(),
            'temperature' => $data['temperature'] ?? null,
            'feels_like' => $data['feels_like'] ?? null,
            'humidity' => $data['humidity'] ?? null,
            'pressure' => $data['pressure'] ?? null,
            'wind_speed' => $data['wind_speed'] ?? null,
            'wind_deg' => $data['wind_deg'] ?? null,
            'cloud_cover' => $data['cloud_cover'] ?? null,
            'rain_1h' => $data['rain_1h'] ?? null,
            'weather_main' => $data['weather_main'] ?? null,
            'weather_description' => $data['weather_description'] ?? null,
            'source' => 'bmkg',
        ]);
    }

    /**
     * Store forecast data
     */
    protected function storeForecastData(Location $location, array $data): void
    {
        $forecasts = $data['forecasts'] ?? [$data];

        foreach ($forecasts as $forecast) {
            $forecastTime = $forecast['datetime'] ?? $forecast['timestamp'] ?? now();

            WeatherPrediction::updateOrCreate(
                [
                    'location_id' => $location->id,
                    'forecast_for' => $forecastTime,
                    'forecast_type' => $data['type'] ?? 'hourly',
                ],
                [
                    'issued_at' => now(),
                    'weather_main' => $forecast['weather'] ?? $forecast['weather_main'] ?? null,
                    'weather_description' => $forecast['description'] ?? null,
                    'weather_icon' => $forecast['icon'] ?? null,
                    'temperature' => $forecast['temperature'] ?? null,
                    'feels_like' => $forecast['feels_like'] ?? null,
                    'temp_min' => $forecast['temp_min'] ?? null,
                    'temp_max' => $forecast['temp_max'] ?? null,
                    'humidity' => $forecast['humidity'] ?? null,
                    'pressure' => $forecast['pressure'] ?? null,
                    'wind_speed' => $forecast['wind_speed'] ?? null,
                    'wind_deg' => $forecast['wind_deg'] ?? null,
                    'cloud_cover' => $forecast['cloud_cover'] ?? null,
                    'rain_probability' => $forecast['rain_probability'] ?? null,
                    'source' => 'bmkg',
                ]
            );
        }
    }

    /**
     * Get current weather by location
     */
    public function getCurrentByLocation(Location $location): ?WeatherHistory
    {
        return WeatherHistory::where('location_id', $location->id)
            ->orderBy('recorded_at', 'desc')
            ->first();
    }

    /**
     * Get hourly forecast for location
     */
    public function getHourlyForecast(Location $location, int $hours = 24)
    {
        return WeatherPrediction::where('location_id', $location->id)
            ->where('forecast_type', 'hourly')
            ->where('forecast_for', '>=', now())
            ->orderBy('forecast_for')
            ->limit($hours)
            ->get();
    }

    /**
     * Get daily forecast for location
     */
    public function getDailyForecast(Location $location, int $days = 7)
    {
        return WeatherPrediction::where('location_id', $location->id)
            ->where('forecast_type', 'daily')
            ->where('forecast_for', '>=', now()->startOfDay())
            ->orderBy('forecast_for')
            ->limit($days)
            ->get();
    }

    /**
     * Get weather history for location
     */
    public function getHistory(Location $location, int $days = 7)
    {
        return WeatherHistory::where('location_id', $location->id)
            ->where('recorded_at', '>=', now()->subDays($days))
            ->orderBy('recorded_at', 'desc')
            ->get();
    }
}

