<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Seed bảng reports
     */
    public function run(): void
    {
        // Report 1: báo cáo comment
        Report::create([
            'sender_id'   => 2,
            'target_id'   => 1,
            'target_type' => 'Comment',
            'reason'      => 'Ngôn từ không phù hợp',
        ]);

        // Report 2: báo cáo recipe
        Report::create([
            'sender_id'   => 1,
            'target_id'   => 2,
            'target_type' => 'Recipe',
            'reason'      => 'Thông tin không chính xác về nguyên liệu',
        ]);

        // Report 3: báo cáo blog
        Report::create([
            'sender_id'   => 2,
            'target_id'   => 1,
            'target_type' => 'Blog',
            'reason'      => 'Nội dung trùng lặp, không hữu ích',
        ]);

        // Report 4: báo cáo câu trả lời trong Q&A
        Report::create([
            'sender_id'   => 1,
            'target_id'   => 2,
            'target_type' => 'QuestionAnswer',
            'reason'      => 'Câu trả lời sai lệch, gây hiểu nhầm',
        ]);
    }
}
