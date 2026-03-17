<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $categoryId = Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id;
        $name = fake()->unique()->words(3, true);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->optional()->paragraph(),
            'egg_type' => fake()->randomElement(['eggless', 'with_egg']),
            'price' => fake()->randomFloat(2, 100, 5000),
            'cost' => fake()->optional(0.8)->randomFloat(2, 50, 4000),
            'image' => 'products/' . fake()->uuid() . '.jpg',
            'is_active' => fake()->boolean(90),
            // 'is_fe' => fake()->boolean(20), // REMOVED
            'category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}