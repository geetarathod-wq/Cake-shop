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
        return [
            'razorpay_order_id' => fake()->optional()->uuid(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'customer_name' => fake()->name(),
            'total_amount' => fake()->randomFloat(2, 100, 5000),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'order_source' => fake()->randomElement(['website', 'walkin', 'phone']),
            'payment_method' => fake()->randomElement(['cod', 'online', 'card']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'order_type' => fake()->randomElement(['preorder', 'walkin', 'delivery', 'pickup', 'custom']),
            'delivery_type' => fake()->randomElement(['standard', 'express']), // Always set, never null
            'coupon_code' => fake()->optional()->word(),
            'discount_amount' => fake()->optional(0.3, 0)->randomFloat(2, 0, 500),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'delivery_date' => fake()->optional()->dateTimeBetween('now', '+1 month'),
            'delivery_slot' => fake()->optional()->randomElement(['morning', 'afternoon', 'evening']),
            'admin_note' => fake()->optional()->sentence(),
            'custom_message' => fake()->optional()->sentence(),
            'name' => fake()->name(),
            'address' => fake()->optional()->address(),
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }
}