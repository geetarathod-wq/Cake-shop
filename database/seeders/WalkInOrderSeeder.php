<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WalkInOrder;

class WalkInOrderSeeder extends Seeder
{
    public function run()
    {
        // Generate a random number between 700 and 900
        $count = rand(700, 900);

        WalkInOrder::factory($count)->create();

        $this->command->info("{$count} walk-in orders seeded.");
    }
}