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

        // Define all available sizes
        $allSizes = ['XS', 'S', 'XM', 'M', 'L', 'XL', '2XL'];
        
        // Randomly select 3-6 sizes for each product
        $selectedSizes = fake()->randomElements($allSizes, fake()->numberBetween(3, 6));
        
        // Sort sizes in logical order
        $sizeOrder = ['XS', 'S', 'XM', 'M', 'L', 'XL', '2XL'];
        usort($selectedSizes, function($a, $b) use ($sizeOrder) {
            return array_search($a, $sizeOrder) - array_search($b, $sizeOrder);
        });

        return [
            'category_id' => fake()->numberBetween(1, 4),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(1),
            'foto_product' => json_encode($images), // Store as JSON array
            'price' => fake()->randomFloat(2, 100000, 300000),
            'stock' => fake()->numberBetween(0, 300),
            'available_sizes' => json_encode($selectedSizes), // Add available sizes
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

    /**
     * Indicate that the product has all sizes available.
     */
    public function withAllSizes(): static
    {
        return $this->state(fn (array $attributes) => [
            'available_sizes' => json_encode(['XS', 'S', 'XM', 'M', 'L', 'XL', '2XL']),
        ]);
    }

    /**
     * Indicate that the product has no sizes (one-size-fits-all or no size selection needed).
     */
    public function withoutSizes(): static
    {
        return $this->state(fn (array $attributes) => [
            'available_sizes' => null,
        ]);
    }
}