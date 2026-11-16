<?php

namespace App\Jobs;

use App\Services\WeatherService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchWeatherData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 3;

    public function __construct()
    {
        //
    }

    public function handle(WeatherService $weatherService): void
    {
        try {
            Log::info('Starting weather data fetch...');

            // Fetch current weather
            $weatherService->fetchCurrentWeather();

            // Fetch forecast
            $weatherService->fetchForecast();

            Log::info('Weather data fetch completed successfully.');
        } catch (\Exception $e) {
            Log::error('Weather data fetch failed: ' . $e->getMessage());
            $this->fail($e);
        }
    }
}

