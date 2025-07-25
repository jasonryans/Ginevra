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
        // Create 30 products with random features (60% chance of having a feature)
        Product::factory(50)->create();
        
        // Create 15 products that explicitly have NO features
        Product::factory(15)->withoutFeature()->create();
        
        // Create 10 products that explicitly have features
        Product::factory(10)->withFeature()->create();
        
        // Create 10 products that are in stock (with random feature assignment)
        Product::factory(10)->inStock()->create();
        
        // Create 5 products that are out of stock and have no features
        Product::factory(5)->outOfStock()->withoutFeature()->create();

        // Create products with all sizes and specific features
        Product::factory(5)->withAllSizes()->withFeature(1)->create(); // All with feature 1
        
        // Create products without size selection and no features
        Product::factory(3)->withoutSizes()->withoutFeature()->create();

        // Create some premium featured products (all with feature 2)
        Product::factory(5)->withFeature(2)->create();
    }
}