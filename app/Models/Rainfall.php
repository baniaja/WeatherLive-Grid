<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rainfall extends Model
{
    protected $table = 'rainfall';
    protected $fillable = [
        'location_id',
        'recorded_at',
        'intensity',
        'amount',
        'duration',
        'rain_type',
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

    public function getRainTypeLabelAttribute(): string
    {
        return match($this->rain_type) {
            'light' => 'Hujan Ringan',
            'moderate' => 'Hujan Sedang',
            'heavy' => 'Hujan Lebat',
            'extreme' => 'Hujan Ekstrem',
            default => 'Tidak Ada Hujan',
        };
    }
}

