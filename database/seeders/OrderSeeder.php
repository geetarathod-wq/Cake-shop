<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $users = User::all();
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->error('No products found. Please run ProductSeeder first.');
            return;
        }

        foreach ($users as $user) {
            // Each user gets 2-8 more orders
            $numOrders = rand(2, 8);
            for ($i = 0; $i < $numOrders; $i++) {
                $order = Order::factory()->create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                ]);

                // Add 1-5 items
                $numItems = rand(1, 5);
                $orderTotal = 0;
                for ($j = 0; $j < $numItems; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    $subtotal = $quantity * $price;
                    $orderTotal += $subtotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                    ]);
                }

                // Apply discount randomly
                $discount = $faker->optional(0.3, 0)->randomFloat(2, 0, 500);
                $order->update([
                    'total_amount' => $orderTotal - $discount,
                    'discount_amount' => $discount,
                ]);
            }
        }

        $this->command->info('Additional orders seeded successfully.');
    }
}