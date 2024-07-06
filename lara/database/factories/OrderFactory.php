<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = User::pluck('id')->toArray();

        return [
            'status' => $this->faker->numberBetween(1, 4),
            'users_id' => $this->faker->randomElement($userIds),
            'summa' => $this->faker->numberBetween
        ];
    }
}
