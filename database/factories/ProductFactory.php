<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('???-###')),
            'category' => fake()->randomElement(['Home & Living', 'Accessories', 'Lighting']),
            'stock' => fake()->numberBetween(0, 150),
            'price' => fake()->randomFloat(2, 100, 5000),
            'variant' => fake()->optional()->words(2, true),
        ];
    }
}
