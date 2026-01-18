<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RecipeIngredient;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RecipeIngredient::create([
            'recipe_id' => 1,
            'ingredient_id' => 1,
            'quantity' => 500,
            'unit' => 'g',
        ]);
        RecipeIngredient::create([
            'recipe_id' => 1,
            'ingredient_id' => 2,
            'quantity' => 200,
            'unit' => 'g',
        ]);
    }
}
