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
    public function run()
    {
        Recipe::create([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Phở bò Hà Nội',
            'description' => 'Món phở truyền thống miền Bắc',
            'main_image' => 'pho-bo.jpg',
            'cooking_time' => 60,
            'difficulty' => 'Medium',
            'servings' => 4,
            'status' => 'Published',
        ]);

        Recipe::create([
            'user_id' => 2,
            'category_id' => 2,
            'title' => 'Mì Quảng',
            'description' => 'Đặc sản miền Trung',
            'main_image' => 'mi-quang.jpg',
            'cooking_time' => 45,
            'difficulty' => 'Easy',
            'servings' => 3,
            'status' => 'Published',
        ]);
    }
}
