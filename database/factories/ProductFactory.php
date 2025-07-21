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
    public function definition(): array
    {
        $images = [
            'https://shopatvelvet.com/wp-content/uploads/2025/01/KANTOR2408-960x1440.jpeg',
            'https://shopatvelvet.com/wp-content/uploads/2025/01/KANTOR2390-960x1440.jpeg' // Example second image
        ];

        return [
            'category_id' => fake()->numberBetween(1, 4),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(1),
            'foto_product' => json_encode($images), // Store as JSON array
            'price' => fake()->randomFloat(2, 10, 1000),
            'stock' => fake()->numberBetween(0, 300),
        ];
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }

    /**
     * Indicate that the product is in stock.
     */
    public function inStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => fake()->numberBetween(10, 100),
        ]);
    }
}