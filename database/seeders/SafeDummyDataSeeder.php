<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SafeDummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // ========== 1. CREATE USERS IF NEEDED ==========
        $targetUsers = 1000;
        $existingCount = User::count();

        if ($existingCount < $targetUsers) {
            $needed = $targetUsers - $existingCount;
            User::factory($needed)->create();
            $this->command->info("Created {$needed} new users. Total users now: " . User::count());
        } else {
            $this->command->info("Already have {$existingCount} users. No new users created.");
        }

        // ========== 2. ENSURE PRODUCTS EXIST ==========
        $productIds = Product::pluck('id')->toArray();
        if (empty($productIds)) {
            $this->command->error('No products found. Please run ProductSeeder first.');
            return;
        }

        // ========== 3. PROCESS USERS IN CHUNKS TO SAVE MEMORY ==========
        User::chunk(100, function ($users) use ($faker, $productIds) {
            $orders = [];
            $orderItems = [];

            foreach ($users as $user) {
                $numOrders = rand(1, 5);
                for ($i = 0; $i < $numOrders; $i++) {
                    $orderData = [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'address' => $user->address,
                        'total_amount' => 0,
                        'discount_amount' => $faker->optional(0.3, 0)->randomFloat(2, 0, 500),
                        'order_type' => $faker->randomElement(['preorder', 'walkin', 'delivery', 'pickup', 'custom']),
                        'status' => $faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
                        'payment_method' => $faker->randomElement(['cod', 'online', 'card']),
                        'custom_message' => $faker->optional()->sentence(),
                        'delivery_date' => $faker->optional()->dateTimeBetween('now', '+1 month'),
                        'delivery_slot' => $faker->optional()->randomElement(['morning', 'afternoon', 'evening']),
                        'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                        'updated_at' => now(),
                    ];
                    $orders[] = $orderData;
                }
            }

            // Insert orders for this chunk
            DB::table('orders')->insert($orders);

            // Get the IDs of the newly inserted orders
            $newOrderIds = DB::table('orders')
                ->whereIn('user_id', $users->pluck('id'))
                ->where('created_at', '>=', now()->subMinute()) // approximate, but safe enough
                ->pluck('id')
                ->toArray();

            // Generate order items for these orders
            foreach ($newOrderIds as $orderId) {
                $numItems = rand(1, 3);
                for ($j = 0; $j < $numItems; $j++) {
                    $productId = $productIds[array_rand($productIds)];
                    $product = Product::find($productId);
                    $price = $product ? $product->price : $faker->randomFloat(2, 100, 2000);
                    $quantity = rand(1, 3);
                    $subtotal = $quantity * $price;
                    $orderItems[] = [
                        'order_id' => $orderId,
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert order items for this chunk
            foreach (array_chunk($orderItems, 500) as $chunk) {
                DB::table('order_items')->insert($chunk);
            }

            // Free memory
            unset($orders, $orderItems, $newOrderIds);
        });

        // ========== 4. UPDATE ORDER TOTALS ==========
        DB::statement("
            UPDATE orders o
            SET total_amount = (
                SELECT COALESCE(SUM(subtotal), 0) - o.discount_amount
                FROM order_items
                WHERE order_id = o.id
            )
        ");

        $this->command->info('Dummy orders and items added successfully.');
    }
}