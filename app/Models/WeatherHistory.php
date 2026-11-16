<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherHistory extends Model
{
    protected $table = 'weather_history';
    protected $fillable = [
        'location_id',
        'station_id',
        'recorded_at',
        'temperature',
        'feels_like',
        'temp_min',
        'temp_max',
        'humidity',
        'pressure',
        'sea_level_pressure',
        'ground_level_pressure',
        'wind_speed',
        'wind_gust',
        'wind_deg',
        'wind_direction',
        'cloud_cover',
        'visibility',
        'uv_index',
        'rain_1h',
        'rain_3h',
        'rain_6h',
        'rain_12h',
        'rain_24h',
        'snow_1h',
        'snow_3h',
        'weather_main',
        'weather_description',
        'weather_icon',
        'weather_code',
        'dew_point',
        'heat_index',
        'source',
    ];

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function station(): BelongsTo
    {
        return $this->belongsTo(WeatherStation::class, 'station_id');
    }
}

