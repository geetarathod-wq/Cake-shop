<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {

        $products = Product::all();

        if ($products->count() == 0) {
            $this->command->info('No products found. Please seed products first.');
            return;
        }

        $walkinPayments = ['cash','upi'];
        $onlinePayments = ['upi','card','netbanking','cod'];

        $statuses = ['pending','processing','delivered'];

        for ($i = 1; $i <= 200; $i++) {

            $orderSource = rand(0,1) ? 'online' : 'walkin';

            $paymentMethod = $orderSource == 'walkin'
                ? $walkinPayments[array_rand($walkinPayments)]
                : $onlinePayments[array_rand($onlinePayments)];

            $deliveryDate = Carbon::create(2026, rand(1,12), rand(1,28));

            $order = Order::create([

                'customer_name' => fake()->name(),

                'phone' => fake()->numerify('9#########'),

                'email' => fake()->safeEmail(),

                'delivery_date' => $deliveryDate,

                'status' => $statuses[array_rand($statuses)],

                'payment_method' => $paymentMethod,

                'order_source' => $orderSource,

                'total_amount' => 0,

                'created_at' => Carbon::create(2026, rand(1,12), rand(1,28)),

                'updated_at' => now()

            ]);

            $total = 0;

            $randomProducts = $products->random(rand(1,4));

            foreach ($randomProducts as $product) {

                $qty = rand(1,3);

                $price = $product->price;

                $subtotal = $qty * $price;

                $total += $subtotal;

                $order->items()->create([

                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal

                ]);
            }

            $order->update([
                'total_amount' => $total
            ]);
        }
    }
}