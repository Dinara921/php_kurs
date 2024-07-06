<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->regexify('[A-Za-z0-9]{5,250}'), 
            'discount' => $this->faker->numberBetween(10, 90),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i:s'),
        ];
    }
}
