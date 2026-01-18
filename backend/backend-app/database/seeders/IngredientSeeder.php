<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Ingredient::create(['name' => 'Thịt bò']);
        Ingredient::create(['name' => 'Bánh phở']);
        Ingredient::create(['name' => 'Hành lá']);
        Ingredient::create(['name' => 'Xương heo']);
    }
}
