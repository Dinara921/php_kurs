<?php

namespace Database\Factories;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
       
        $productIds = Product::pluck('id')->toArray();
        $orderIds = Order::pluck('id')->toArray();
        return 
        [
            'products_id' => $this->faker->randomElement($productIds),
            'count' => $this->faker->numberBetween,
            'order_id' => $this->faker->randomElement($orderIds),
            'price' => $this->faker->numberBetween
        ];
    }
}
