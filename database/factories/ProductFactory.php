<?php

namespace Database\Factories;

use App\Models\CategoryProduct;
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
        $availableCategory=CategoryProduct::all();
        return [
            //
            'product_category_id' => $availableCategory->random()->id,
            'name' => $this->faker->word(),
            'price' => $this->faker->randomNumber(6,true),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
