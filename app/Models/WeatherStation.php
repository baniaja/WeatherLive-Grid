<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WeatherStation extends Model
{
    protected $fillable = [
        'name',
        'code',
        'location_id',
        'latitude',
        'longitude',
        'elevation',
        'type',
        'status',
        'provider',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'metadata' => 'array',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function weatherHistory(): HasMany
    {
        return $this->hasMany(WeatherHistory::class, 'station_id');
    }
}

