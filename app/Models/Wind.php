<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wind extends Model
{
    protected $table = 'wind';
    protected $fillable = [
        'location_id',
        'recorded_at',
        'speed',
        'gust',
        'deg',
        'direction_cardinal',
        'speed_beaufort',
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

