<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    /**
     * Seed bảng recipes
     */
    public function run(): void
    {
        Recipe::create([
            'user_id' => 1,        // admin
            'category_id' => 1,    // Miền Bắc
            'title' => 'Phở bò Hà Nội',
            'description' => 'Món phở truyền thống miền Bắc',
            'main_image' => 'recipes/pho-bo.jpg',
            'cooking_time' => 60,
            'difficulty' => 'Medium',
            'servings' => 4,
        ]);

        Recipe::create([
            'user_id' => 2,        // member
            'category_id' => 2,    // Miền Trung
            'title' => 'Mì Quảng',
            'description' => 'Đặc sản miền Trung',
            'main_image' => 'recipes/mi-quang.jpg',
            'cooking_time' => 45,
            'difficulty' => 'Easy',
            'servings' => 3,
        ]); 
    }
}