<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CookbookDetail;

class CookbookDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        CookbookDetail::create([
            'cookbook_id' => 1,
            'recipe_id' => 1,
        ]);
    }
}
