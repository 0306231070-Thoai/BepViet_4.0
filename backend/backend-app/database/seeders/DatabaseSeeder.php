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
            // 1. Gốc
            UserSeeder::class,

            // 2. Master data
            CategorySeeder::class,
            IngredientSeeder::class,

            // 3. Bảng chính
            RecipeSeeder::class,
            CookbookSeeder::class,
            BlogSeeder::class,

            // 4. Bảng phụ
            RecipeStepSeeder::class,
            CommentSeeder::class,
            QuestionAnswerSeeder::class,

            // 5. Bảng trung gian
            RecipeIngredientSeeder::class,
            CookbookDetailSeeder::class,

            // 6. Hệ thống
            FollowSeeder::class,
            ReportSeeder::class,
        ]);


        User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
