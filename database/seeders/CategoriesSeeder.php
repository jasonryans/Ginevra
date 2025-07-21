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
            ['id' => 1, 'name' => 'Tops'],
            ['id' => 2, 'name' => 'Outerwear'],
            ['id' => 3, 'name' => 'Bottoms'],
            ['id' => 4, 'name' => 'Dress']
        ]);
    }
}
