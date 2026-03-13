<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Assuming categories exist; if not, create a few
        if (Category::count() == 0) {
            Category::factory(5)->create();
        }

        Product::factory(50)->create();
    }
}