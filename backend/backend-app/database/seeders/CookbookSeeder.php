<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cookbook;

class CookbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * Seed bảng cookbooks
     */
    public function run(): void
    {
        Cookbook::create([
            'user_id' => 2,
            'name' => 'Món Bắc yêu thích',
            'description' => 'Các món miền Bắc ngon nhất',
        ]);
    }
}
