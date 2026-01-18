<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    /**
     * Seed bảng blogs
     */
    public function run(): void
    {
        Blog::create([
            'user_id' => 1,
            'title' => 'Ẩm thực miền Bắc',
            'content' => 'Giới thiệu các món ăn truyền thống miền Bắc.',
            'image' => 'amthuc-bac.jpg',
        ]);
    }
}
