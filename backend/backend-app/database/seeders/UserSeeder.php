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
    
    /**
     * Seed bảng users
     * - Tạo sẵn admin và member để làm dữ liệu gốc
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@bepviet.com',
            'password' => Hash::make('123456'),
            'bio' => 'Quản trị viên hệ thống',
            'avatar' => null,
            // role, status dùng default trong migration
        ]);

        User::create([
            'username' => 'member1',
            'email' => 'member1@bepviet.com',
            'password' => Hash::make('123456'),
            'bio' => 'Thành viên yêu thích món Việt',
            'avatar' => null,
        ]);
    }
}
