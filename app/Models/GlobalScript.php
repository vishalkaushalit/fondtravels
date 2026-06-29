<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class GlobalScript extends Model
{
    protected $fillable = [
        'header_scripts',
        'body_scripts',
        'footer_scripts',
    ];

    public static function findCurrent(): ?self
    {
        try {
            return self::query()->first();
        } catch (QueryException) {
            return null;
        }
    }
}
