<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeatherPrediction extends Model
{
    protected $fillable = [
        'location_id',
        'forecast_for',
        'issued_at',
        'weather_main',
        'weather_description',
        'weather_icon',
        'weather_code',
        'temperature',
        'feels_like',
        'temp_min',
        'temp_max',
        'humidity',
        'pressure',
        'wind_speed',
        'wind_deg',
        'wind_gust',
        'cloud_cover',
        'visibility',
        'uv_index',
        'rain_probability',
        'rain_volume',
        'source',
        'forecast_type',
        'raw_data',
    ];

    protected function casts(): array
    {
        return [
            'forecast_for' => 'datetime',
            'issued_at' => 'datetime',
            'raw_data' => 'array',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function actuals(): HasMany
    {
        return $this->hasMany(WeatherActual::class, 'prediction_id');
    }

    public function accuracies(): HasMany
    {
        return $this->hasMany(WeatherAccuracy::class, 'prediction_id');
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(WeatherCorrection::class, 'prediction_id');
    }
}

