<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DummyCustomerDataSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data (in correct order)
        OrderItem::truncate();
        Order::truncate();
        User::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Create 1000 users
        $users = User::factory(1000)->create();

        // For each user, create 1 to 5 orders
        foreach ($users as $user) {
            $numOrders = rand(1, 5);
            for ($i = 0; $i < $numOrders; $i++) {
                // Create an order for this user (without total_amount initially)
                $order = Order::factory()->create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'total_amount' => 0, // placeholder
                ]);

                // Create 1 to 3 order items for this order
                $numItems = rand(1, 3);
                $itemsTotal = 0;
                for ($j = 0; $j < $numItems; $j++) {
                    $item = OrderItem::factory()->create([
                        'order_id' => $order->id,
                    ]);
                    $itemsTotal += $item->quantity * $item->price;
                }

                // Update order total_amount based on items subtotal and discount
                $order->total_amount = $itemsTotal - $order->discount_amount;
                $order->save();
            }
        }
    }
}