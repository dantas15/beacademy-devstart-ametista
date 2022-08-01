<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cost = $this->faker->randomFloat(2, 0, 100);
        $sale = $cost + ($cost * 0.2);
        $sale = number_format($sale, 2, '.', '');

        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(10),
            'amount' => $this->faker->numberBetween(1, 100),
            'cost_price' => $cost,
            'sale_price' => $sale,
            'main_photo' => $this->faker->imageUrl(300, 300),
            'category_id' => Category::factory(),
        ];
    }
}
