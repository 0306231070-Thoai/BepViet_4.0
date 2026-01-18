<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run() {
        DB::table('follows')->insert([
            'follower_id' => 2,
            'following_id' => 1,
        ]);
    }
}
