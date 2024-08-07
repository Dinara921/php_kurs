<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
         return [
        'email' => $this->faker->unique()->safeEmail,
        'password' => bcrypt('password'), 
        'name' => $this->faker->name,
        'address' => $this->faker->address,
        'phone' => $this->faker->numberBetween(1000000000, 2147483647)
         ];
    }
}
