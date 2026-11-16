<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherSensor extends Model
{
    protected $fillable = [
        'name',
        'sensor_id',
        'location_id',
        'type',
        'model',
        'status',
        'config',
        'last_reading_at',
    ];

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'last_reading_at' => 'datetime',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}

