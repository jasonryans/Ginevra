<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'tops'],
            ['id' => 2, 'name' => 'outerwear'],
            ['id' => 3, 'name' => 'bottoms'],
            ['id' => 4, 'name' => 'dresses']
        ]);
    }
}
