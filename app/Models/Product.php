<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'status',
        'thumbnail'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
