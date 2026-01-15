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
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            FollowSeeder::class,
            CategorySeeder::class,
            RecipeSeeder::class,
            RecipeStepSeeder::class,
            IngredientSeeder::class,
            RecipeIngredientSeeder::class,
            CommentSeeder::class,
            CookbookSeeder::class,
            CookbookDetailSeeder::class,
            BlogSeeder::class,
            QuestionAnswerSeeder::class,
            ReportSeeder::class,
        ]);

        User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
