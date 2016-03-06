<?php

namespace Intelitkz\Laraveltools\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends \Eloquent
{
    use SoftDeletes;

    protected $fillable = ['key', 'value'];

    public static function set($key, $value)
    {
        $option = self::firstOrNew(['key' => $key]);
        $option->primaryKey = 'key';
        $option->value = $value;
        $option->save();
    }

    public static function get($key)
    {
        $option = self::where('key', $key)->first();
        return data_get($option, 'value');
    }
}
