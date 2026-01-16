<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Report::create([
            'sender_id' => 2,
            'target_id' => 1,
            'target_type' => 'Comment',
            'reason' => 'Ngôn từ không phù hợp',
            'status' => 'Pending',
        ]);
    }
}
