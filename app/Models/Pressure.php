<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pressure extends Model
{
    protected $table = 'pressure';
    protected $fillable = [
        'location_id',
        'recorded_at',
        'surface',
        'sea_level',
        'ground_level',
        'trend',
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

