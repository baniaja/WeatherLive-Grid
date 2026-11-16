<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = [
        'name',
        'code',
        'latitude',
        'longitude',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }
}

