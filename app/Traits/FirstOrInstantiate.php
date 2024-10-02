<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait FirstOrInstantiate
{
    public static function firstOrInstantiate(array $attributes = [])
    {
        return self::class::where($attributes)->first() ?? new self::class;
    }
}
