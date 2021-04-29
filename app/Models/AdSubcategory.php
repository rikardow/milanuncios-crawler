<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdSubcategory extends Model
{
    protected $fillable = ['name', 'category_id', 'url'];
    public $timestamps = false;

    use HasFactory;
}
