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
    'short_description',
    'description',
    'price',
    'discount_price',
    'stock',
    'sku',
    'thumbnail',
    'is_active',
    'is_featured',
    'meta_title',
    'meta_description',
];
public function category()
{
    return $this->belongsTo(Category::class);
}
}
