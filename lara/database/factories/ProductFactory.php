<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sale;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\CountryProduct;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $saleIds = Sale::pluck('id')->toArray();
        $categoryProductIds = CategoryProduct::pluck('id')->toArray();
        $countryProductIds = CountryProduct::pluck('id')->toArray();

        return [
            'name' => $this->faker->name,
            'category_id' => $this->faker->randomElement($categoryProductIds),
            'country_id' => $this->faker->randomElement($countryProductIds),
            'img' => $this->faker->text,
            'sale_id' => $this->faker->randomElement($saleIds),
            'count' => $this->faker->numberBetween,
            'price' => $this->faker->numberBetween
        ];
    }
}
