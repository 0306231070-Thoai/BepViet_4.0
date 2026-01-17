<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuestionAnswer;

class QuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * Seed bảng question_answers
     * - Bao gồm câu hỏi và câu trả lời
     */
    public function run(): void
    {
        $question = QuestionAnswer::create([
            'user_id' => 2,
            'content' => 'Làm sao để nấu phở bò ngon?',
        ]);

        QuestionAnswer::create([
            'parent_id' => $question->id,
            'user_id' => 1,
            'content' => 'Nên hầm xương ít nhất 6 tiếng.',
        ]);
    }
}
