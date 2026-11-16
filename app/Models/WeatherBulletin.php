<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherBulletin extends Model
{
    protected $fillable = [
        'title',
        'category',
        'summary',
        'content',
        'author',
        'severity',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
}
