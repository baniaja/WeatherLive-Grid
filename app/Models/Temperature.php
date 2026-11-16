<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Temperature extends Model
{
    protected $table = 'temperature';
    protected $fillable = [
        'location_id',
        'recorded_at',
        'current',
        'feels_like',
        'min',
        'max',
        'dew_point',
        'wet_bulb',
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

