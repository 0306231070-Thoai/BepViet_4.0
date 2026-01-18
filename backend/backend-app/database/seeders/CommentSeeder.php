<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * Seed bảng comments
     */
    public function run(): void
    {
        Comment::create([
            'recipe_id' => 1,
            'user_id' => 2,
            'content' => 'Phở rất ngon, nước dùng đậm đà!',
            'rating_star' => null, // không bắt buộc đánh giá
        ]);
    }
}
