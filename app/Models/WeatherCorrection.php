<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherCorrection extends Model
{
    protected $fillable = [
        'location_id',
        'prediction_id',
        'accuracy_id',
        'original_temperature',
        'original_weather',
        'corrected_temperature',
        'corrected_weather',
        'correction_factor',
        'correction_reason',
        'confidence_score',
        'model_used',
        'model_accuracy',
        'is_applied',
        'applied_at',
    ];

    protected function casts(): array
    {
        return [
            'is_applied' => 'boolean',
            'applied_at' => 'datetime',
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

    public function accuracy(): BelongsTo
    {
        return $this->belongsTo(WeatherAccuracy::class, 'accuracy_id');
    }
}

