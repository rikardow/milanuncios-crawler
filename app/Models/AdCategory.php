<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdCategory extends Model
{
    protected $fillable = ['name', 'icon'];
    public $timestamps = false;

    use HasFactory;
}
