<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $orderTypes = ['preorder', 'walkin', 'delivery', 'pickup', 'custom'];
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentMethods = ['cod', 'online', 'card'];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? null,
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->optional()->address(),
            'total_amount' => fake()->randomFloat(2, 100, 5000),
            'discount_amount' => fake()->optional(0.3, 0)->randomFloat(2, 0, 500),
            'order_type' => fake()->randomElement($orderTypes),
            'status' => fake()->randomElement($statuses),
            'payment_method' => fake()->randomElement($paymentMethods),
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }
}