<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherActual extends Model
{
    protected $table = 'weather_actual';
    protected $fillable = [
        'location_id',
        'prediction_id',
        'observed_at',
        'weather_main',
        'weather_description',
        'weather_icon',
        'weather_code',
        'temperature',
        'feels_like',
        'humidity',
        'pressure',
        'wind_speed',
        'wind_deg',
        'cloud_cover',
        'rain_1h',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'observed_at' => 'datetime',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function prediction(): BelongsTo
    {
        return $this->belongsTo(WeatherPrediction::class, 'prediction_id');
    }
}

