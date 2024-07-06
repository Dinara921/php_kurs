<?php

namespace Database\Factories;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = Product::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        $orderIds = Order::pluck('id')->toArray();
        return 
        [
            'products_id' => $this->faker->randomElement($productIds),
            'user_id' => $this->faker->randomElement($userIds),
            'order_id' => $this->faker->randomElement($orderIds),
            'text' => $this->faker->text,
            'grade' => $this->faker->numberBetween(1, 5)
        ];
    }
}
