<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder {
    public function run(): void {
        Product::truncate();
        $cakes = [
            ['name' => 'Midnight Choco Pearl', 'price' => 45.00, 'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1000'],
            ['name' => 'Golden Vanilla Bean', 'price' => 38.50, 'image' => 'https://images.unsplash.com/photo-1535141192574-5d4897c12636?q=80&w=1000'],
            ['name' => 'Ruby Velvet Dream', 'price' => 52.00, 'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?q=80&w=1000'],
            ['name' => 'Artisanal Caramel', 'price' => 48.00, 'image' => 'https://images.unsplash.com/photo-1464347744102-11db6282f854?q=80&w=1000']
        ];
        foreach ($cakes as $cake) { Product::create($cake); }
    }
}