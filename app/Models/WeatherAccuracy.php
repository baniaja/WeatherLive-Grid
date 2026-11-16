<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherAccuracy extends Model
{
    protected $table = 'weather_accuracy';
    protected $fillable = [
        'location_id',
        'prediction_id',
        'actual_id',
        'evaluated_at',
        'temp_predicted',
        'temp_actual',
        'temp_difference',
        'weather_predicted',
        'weather_actual_condition',
        'weather_match',
        'humidity_predicted',
        'humidity_actual',
        'humidity_difference',
        'wind_speed_predicted',
        'wind_speed_actual',
        'wind_speed_difference',
        'pressure_predicted',
        'pressure_actual',
        'pressure_difference',
        'status',
        'accuracy_score',
        'metrics',
    ];

    protected function casts(): array
    {
        return [
            'evaluated_at' => 'datetime',
            'weather_match' => 'boolean',
            'metrics' => 'array',
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

    public function actual(): BelongsTo
    {
        return $this->belongsTo(WeatherActual::class, 'actual_id');
    }
}

