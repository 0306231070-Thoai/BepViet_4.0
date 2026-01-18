<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * Seed bảng recipe_ingredients
     * - Lưu số lượng và đơn vị cho từng công thức
     */
    public function run(): void
    {
        DB::table('recipe_ingredients')->insert([
            [
                'recipe_id' => 1,
                'ingredient_id' => 1,
                'quantity' => 500,
                'unit' => 'g',
            ],
            [
                'recipe_id' => 1,
                'ingredient_id' => 2,
                'quantity' => 200,
                'unit' => 'g',
            ],
        ]);
    }
}
