<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [

            [
                'category' => 'Skincare',
                'name' => 'Glow Serum',
                'price' => 129000,
                'stock' => 20,
            ],

            [
                'category' => 'Makeup',
                'name' => 'Soft Matte Cushion',
                'price' => 189000,
                'stock' => 15,
            ],

            [
                'category' => 'Bodycare',
                'name' => 'Body Lotion Bright',
                'price' => 99000,
                'stock' => 30,
            ],

        ];

        foreach ($products as $item) {

            $category = Category::where(
                'name',
                $item['category']
            )->first();

            Product::create([

                'category_id' => $category->id,

                'name' => $item['name'],

                'slug' => Str::slug($item['name']),

                'short_description' =>
                    $item['name'] . ' short description',

                'description' =>
                    $item['name'] . ' full description',

                'price' => $item['price'],

                'discount_price' => null,

                'stock' => $item['stock'],

                'sku' => strtoupper(Str::random(8)),

                'thumbnail' => null,

                'is_active' => true,

                'is_featured' => true,

                'meta_title' => $item['name'],

                'meta_description' =>
                    $item['name'] . ' meta description',
            ]);
        }
    }
}