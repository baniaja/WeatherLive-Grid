<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satellite extends Model
{
    protected $table = 'satellite';
    protected $fillable = [
        'satellite_name',
        'image_type',
        'image_url',
        'metadata',
        'captured_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'captured_at' => 'datetime',
        ];
    }
}

