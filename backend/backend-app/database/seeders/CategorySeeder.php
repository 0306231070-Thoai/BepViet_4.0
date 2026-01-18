<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    /**
     * Seed bảng categories
     * - Danh mục công thức
     */
     public function run() {
        Category::create(['name' => 'Miền Bắc', 'description' => 'Ẩm thực miền Bắc', 'slug' => 'mien-bac']);
        Category::create(['name' => 'Miền Trung', 'description' => 'Ẩm thực miền Trung', 'slug' => 'mien-trung']);
        Category::create(['name' => 'Miền Nam', 'description' => 'Ẩm thực miền Nam', 'slug' => 'mien-nam']);
    }
}
