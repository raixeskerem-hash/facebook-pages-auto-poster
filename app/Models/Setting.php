<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
    ];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('setting_key', $key)->first();
        return $setting ? $setting->setting_value : $default;
    }

    public static function set(string $key, $value, string $type = 'string'): self
    {
        return static::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value, 'setting_type' => $type]
        );
    }
}
