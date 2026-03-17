<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        $product = Product::inRandomOrder()->first();
        if (!$product) {
            $product = Product::factory()->create();
        }
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $product->price;
        $subtotal = $quantity * $price;

        return [
            'order_id' => Order::inRandomOrder()->first()->id ?? Order::factory(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}