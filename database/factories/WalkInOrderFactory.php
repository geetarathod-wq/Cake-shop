<?php

namespace Database\Factories;

use App\Models\WalkInOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalkInOrderFactory extends Factory
{
    protected $model = WalkInOrder::class;

    public function definition()
    {
        return [
            'customer_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->optional()->email(),
            'address' => fake()->optional()->address(),
            'order_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'delivery_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'), // Always set
            'delivery_slot' => fake()->randomElement(['morning', 'afternoon', 'evening']),
            'order_type' => fake()->randomElement(['pickup', 'delivery']),
            'admin_note' => fake()->optional()->sentence(),
            'payment_method' => fake()->randomElement(['cash', 'upi', 'card']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'subtotal' => fake()->randomFloat(2, 100, 5000),
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'updated_at' => now(),
        ];
    }
}