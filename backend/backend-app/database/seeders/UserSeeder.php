<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'email' => 'admin@bepviet.com',
            'role' => 'admin',
            'bio' => 'Quản trị viên hệ thống',
            'status' => true,
        ]);

        User::create([
            'username' => 'member1',
            'password' => Hash::make('123456'),
            'email' => 'member1@bepviet.com',
            'role' => 'member',
            'bio' => 'Thành viên yêu thích món Việt',
            'status' => true,
        ]);
    }
}
