<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create categories with meaningful names
        $categories = [
            'Birthday Cakes',
            'Wedding Cakes',
            'Anniversary Cakes',
            'Cupcakes',
            'Pastries',
            'Cookies',
            'Custom Cakes',
            'Seasonal Specials',
        ];

        foreach ($categories as $catName) {
            Category::firstOrCreate(
                ['name' => $catName],
                [
                    'slug' => Str::slug($catName),
                    // 'description' => "Delicious {$catName} for every occasion.", // REMOVED because column doesn't exist
                ]
            );
        }

        // Get category IDs after creation
        $categoryIds = Category::pluck('id', 'name')->toArray();

        // Birthday Cakes - 15
        for ($i = 1; $i <= 15; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Birthday Cakes'],
                'name' => "Birthday Cake {$i}",
            ]);
        }

        // Wedding Cakes - 8
        for ($i = 1; $i <= 8; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Wedding Cakes'],
                'name' => "Wedding Cake {$i}",
                'price' => fake()->randomFloat(2, 3000, 15000),
            ]);
        }

        // Anniversary Cakes - 10
        for ($i = 1; $i <= 10; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Anniversary Cakes'],
                'name' => "Anniversary Cake {$i}",
            ]);
        }

        // Cupcakes - 20
        for ($i = 1; $i <= 20; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Cupcakes'],
                'name' => "Cupcake {$i}",
                'price' => fake()->randomFloat(2, 50, 200),
            ]);
        }

        // Pastries - 15
        for ($i = 1; $i <= 15; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Pastries'],
                'name' => "Pastry {$i}",
                'price' => fake()->randomFloat(2, 80, 250),
            ]);
        }

        // Cookies - 12
        for ($i = 1; $i <= 12; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Cookies'],
                'name' => "Cookie {$i}",
                'price' => fake()->randomFloat(2, 30, 150),
            ]);
        }

        // Custom Cakes - 10
        for ($i = 1; $i <= 10; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Custom Cakes'],
                'name' => "Custom Cake {$i}",
            ]);
        }

        // Seasonal Specials - 8
        for ($i = 1; $i <= 8; $i++) {
            Product::factory()->create([
                'category_id' => $categoryIds['Seasonal Specials'],
                'name' => "Seasonal Special {$i}",
            ]);
        }

        $this->command->info('Categories and products seeded successfully.');
    }
}