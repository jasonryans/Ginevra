<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'username' => 'testuser', 
            'email' => 'test@example.com',
            'password' => bcrypt('test123'), 
            'is_admin' => '1', 
        ]);

        User::factory()->create([
            'name' => 'James',
            'username' => 'jameslee', 
            'email' => 'james1@gmail.com',
            'password' => bcrypt('james123'), 
            'is_admin' => '0', 
        ]);

        $this->call([
            FeatureSeeder::class,
            CategoriesSeeder::class, 
            ProductSeeder::class,
        ]);
    }
}