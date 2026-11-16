<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'label'];

    public static function get(string $key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value, string $group = 'general', ?string $label = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'label' => $label]
        );
        Cache::forget("site_setting_{$key}");
        Cache::forget('all_site_settings');
        return $setting;
    }

    public static function allKeyed()
    {
        return Cache::remember('all_site_settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }
}
