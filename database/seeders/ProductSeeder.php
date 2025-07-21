<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 50 products with random stock
        Product::factory(50)->create();
        
        // Create 10 products that are in stock
        Product::factory(10)->inStock()->create();
        
        // Create 5 products that are out of stock
        Product::factory(5)->outOfStock()->create();

        // Create products with all sizes
        Product::factory(5)->withAllSizes()->create();

        // Create products without size selection
        Product::factory(3)->withoutSizes()->create();

        // Create regular products with random sizes (default behavior)
        Product::factory(10)->create();
    }
}