<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'desc',
        'price',
        'slug',
        'cod',
        'manufacturer',
        'country',
        'view',
        'substance',
        'recipe',
        'exception'
    ];
}
