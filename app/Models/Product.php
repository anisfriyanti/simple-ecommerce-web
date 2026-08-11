<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Product extends Model
{
      use SoftDeletes;
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

protected $casts = [
    'stock' => 'integer',
    'is_active' => 'boolean',
    'is_featured' => 'boolean',
];

public function category()
{
    return $this->belongsTo(Category::class);
}
public function products()
{
    return $this->hasMany(
        Product::class
    );
}

}
