<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirQuality extends Model
{
protected $table = 'air_quality';

    protected $fillable = [
        'location_id',
        'recorded_at',
        'aqi',
        'pm2_5',
        'pm10',
        'ozone',
        'nitrogen_dioxide',
        'sulphur_dioxide',
        'carbon_monoxide',
        'ammonia',
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
}

