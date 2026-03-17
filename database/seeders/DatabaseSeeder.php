<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // First create products and categories
            ProductSeeder::class,
            // Then create users and initial orders (SafeDummyDataSeeder also creates orders)
            SafeDummyDataSeeder::class,
            // Add more orders for existing users
            OrderSeeder::class,
            // Finally create walk-in orders
            WalkInOrderSeeder::class,
        ]);
    }
}