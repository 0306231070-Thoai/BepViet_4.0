<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */

    /**
     * Gọi toàn bộ seeder theo đúng thứ tự khóa ngoại
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // --- Công thức sắp Seeder ---

        /**
         * 1. User (gốc)
         * 2. Category / Ingredient (master data)
         * 3. Bảng chính (Recipe, Blog…)
         * 4. Bảng phụ (Step, Comment…)
         * 5. Bảng trung gian (pivot)
         * 6. Bảng hệ thống (Follow, Report)
         */

        $this->call([
            UserSeeder::class,

            CategorySeeder::class,
            IngredientSeeder::class,

            RecipeSeeder::class,
            BlogSeeder::class,

            RecipeStepSeeder::class,
            RecipeIngredientSeeder::class,

            CommentSeeder::class,
            QuestionAnswerSeeder::class,

            FollowSeeder::class,
            ReportSeeder::class,
        ]);

        User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
