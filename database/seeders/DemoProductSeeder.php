<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class DemoProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'skincare'],
            ['name' => 'Skincare']
        );

        Product::create([
            'category_id' => $category->id,
            'name' => 'Serum Brightening',
            'slug' => Str::slug('Serum Brightening'),
            'description' => 'Serum wajah untuk tampilan kulit lebih cerah dan sehat.',
            'price' => 75000,
            'stock' => 20,
            'image' => null,
            'is_featured' => true,
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Moisturizer Calm Skin',
            'slug' => Str::slug('Moisturizer Calm Skin'),
            'description' => 'Pelembap ringan untuk kulit normal dan kering.',
            'price' => 89000,
            'stock' => 15,
            'image' => null,
            'is_featured' => false,
        ]);
    }
}