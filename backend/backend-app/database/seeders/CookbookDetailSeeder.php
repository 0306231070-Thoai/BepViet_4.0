<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CookbookDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * Seed bảng cookbook_details
     */
    public function run(): void
    {
        DB::table('cookbook_details')->insert([
            'cookbook_id' => 1,
            'recipe_id' => 1,
        ]);
    }
}
