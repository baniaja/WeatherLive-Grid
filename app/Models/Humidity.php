<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Humidity extends Model
{
    protected $table = 'humidity';
    protected $fillable = [
        'location_id',
        'recorded_at',
        'relative',
        'absolute',
        'specific',
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

