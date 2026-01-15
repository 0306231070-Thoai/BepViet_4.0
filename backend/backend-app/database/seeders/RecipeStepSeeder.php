<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RecipeStep;

class RecipeStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        RecipeStep::create([
            'recipe_id' => 1,
            'step_order' => 1,
            'instruction' => 'Hầm xương bò ít nhất 6 tiếng để lấy nước dùng.',
        ]);
        RecipeStep::create([
            'recipe_id' => 1,
            'step_order' => 2,
            'instruction' => 'Chần bánh phở, thêm thịt bò và hành lá.',
        ]);
    }
}
