<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radar extends Model
{
    protected $table = 'radar';
    protected $fillable = [
        'station_name',
        'radar_type',
        'image_url',
        'data',
        'latitude',
        'longitude',
        'captured_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'captured_at' => 'datetime',
        ];
    }
}

