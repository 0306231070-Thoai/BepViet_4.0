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
    public function run()
    {
        Cookbook::create([
            'user_id' => 2,
            'name' => 'Món Bắc yêu thích',
            'description' => 'Tổng hợp các món miền Bắc',
        ]);
    }
}
