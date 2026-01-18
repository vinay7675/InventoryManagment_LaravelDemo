<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'product_code' => 'PM-PCE-' . $this->faker->unique()->numberBetween(1000, 9999),
            'hsn_code' => null,
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'status' => 'active'
        ];
    }
}
