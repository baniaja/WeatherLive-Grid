<?php

use App\Jobs\EvaluateAccuracy;
use App\Jobs\FetchWeatherData;
use Illuminate\Support\Facades\Schedule;

// Fetch weather data from BMKG every 10 minutes
Schedule::job(new FetchWeatherData())->everyTenMinutes()->appendOutputTo(storage_path('logs/weather-fetch.log'));

// Evaluate prediction accuracy every hour
Schedule::job(new EvaluateAccuracy())->hourly()->appendOutputTo(storage_path('logs/accuracy-eval.log'));

// Clear old cache daily
Schedule::command('cache:clear')->daily()->at('03:00');

// Prune old weather data (keep last 30 days of detailed data)
Schedule::command('model:prune')->daily();
