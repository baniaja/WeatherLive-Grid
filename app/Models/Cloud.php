<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cloud extends Model
{
    protected $table = 'cloud';
    protected $fillable = [
        'location_id',
        'recorded_at',
        'cover',
        'type',
        'base',
        'top',
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

