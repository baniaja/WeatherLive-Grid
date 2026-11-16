<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalFeature extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon',
        'badge',
        'url',
        'category',
        'is_active',
        'order_index',
        'target_role'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];
}
