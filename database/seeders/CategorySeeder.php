<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name' => 'Skincare',
                'slug' => 'skincare',
            ],

            [
                'name' => 'Makeup',
                'slug' => 'makeup',
            ],

            [
                'name' => 'Bodycare',
                'slug' => 'bodycare',
            ],

        ];

        foreach ($categories as $category) {

            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['name'] . ' category',
                'is_active' => true,
            ]);
        }
    }
}