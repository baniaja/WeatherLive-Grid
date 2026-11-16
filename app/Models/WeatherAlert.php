<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherAlert extends Model
{
    protected $fillable = [
        'location_id',
        'title',
        'description',
        'alert_type',
        'severity',
        'issued_at',
        'effective_from',
        'effective_until',
        'source',
        'data',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'effective_from' => 'datetime',
            'effective_until' => 'datetime',
            'data' => 'array',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('effective_from', '<=', now())
            ->where(function ($q) {
                $q->whereNull('effective_until')
                    ->orWhere('effective_until', '>=', now());
            });
    }
}

