<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run()
    {
        DB::table('features')->insert([
            ['id' => 1, 'name' => 'Best Sellers'],
            ['id' => 2, 'name' => 'New Arrivals'],
        ]);
    }
}