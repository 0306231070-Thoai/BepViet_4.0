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
    public function run()
    {
        $question = QuestionAnswer::create([
            'user_id' => 2,
            'content' => 'Làm thế nào để nấu phở bò ngon?',
        ]);

        QuestionAnswer::create([
            'parent_id' => $question->id,
            'user_id' => 1,
            'content' => 'Bạn nên hầm xương bò ít nhất 6 tiếng để nước dùng ngọt.',
        ]);
    }
}
