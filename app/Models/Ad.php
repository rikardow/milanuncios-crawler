<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $guarded = [];

    use HasFactory;

    public static function getRecent()
    {
        return self::orderBy('id', 'desc')->take(50)->get();
    }
}
