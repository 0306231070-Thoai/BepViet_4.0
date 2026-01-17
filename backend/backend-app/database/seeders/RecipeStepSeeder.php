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
    
     /**
     * Seed bảng recipe_steps
     * - Các bước nấu của công thức
     */
    public function run(): void
    {
        RecipeStep::create([
            'recipe_id' => 1,
            'step_order' => 1,
            'instruction' => 'Hầm xương bò ít nhất 6 tiếng để lấy nước dùng.',
            'media_url' => null,
        ]);

        RecipeStep::create([
            'recipe_id' => 1,
            'step_order' => 2,
            'instruction' => 'Chần bánh phở, thêm thịt bò và hành lá.',
            'media_url' => null,
        ]);
    }
}
