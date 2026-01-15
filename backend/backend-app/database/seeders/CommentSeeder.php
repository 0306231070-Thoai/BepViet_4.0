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
    public function run()
    {
        Comment::create([
            'recipe_id' => 1,
            'user_id' => 2,
            'content' => 'Phở ngon tuyệt, nước dùng ngọt!',
            'rating_star' => 5,
        ]);
    }
}
