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

    /**
     * Seed bảng follows
     * - Quan hệ theo dõi giữa user
     */
    public function run(): void
    {
        DB::table('follows')->insert([
            'follower_id' => 2,
            'following_id' => 1,
        ]);
    }
}
