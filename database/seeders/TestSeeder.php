<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Test seeder ran successfully!');
    }
}