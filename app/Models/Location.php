<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'bmkg_code',
        'latitude',
        'longitude',
        'elevation',
        'timezone',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function weatherHistory(): HasMany
    {
        return $this->hasMany(WeatherHistory::class);
    }

    public function weatherPredictions(): HasMany
    {
        return $this->hasMany(WeatherPrediction::class);
    }

    public function weatherAlerts(): HasMany
    {
        return $this->hasMany(WeatherAlert::class);
    }

    public function stations(): HasMany
    {
        return $this->hasMany(WeatherStation::class);
    }
}

