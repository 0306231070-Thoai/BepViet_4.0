<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions_answers', function (Blueprint $table) {
            $table->id(); // Mã câu hỏi/trả lời (PK)

            $table->unsignedBigInteger('parent_id')->nullable(); // ID câu hỏi gốc (NULL nếu là câu hỏi)
            // ID câu hỏi gốc (FK → chính bảng questions_answers.id, NULL nếu là câu hỏi)
            $table->foreign('parent_id')->references('id')->on('questions_answers')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người hỏi/trả lời (FK → users.id)
            $table->text('content'); // Nội dung trao đổi (câu hỏi hoặc câu trả lời)
            $table->timestamps(); // created_at & updated_at
        });
    }
    
// Giải thích

// id: khóa chính, định danh cho mỗi câu hỏi hoặc câu trả lời.

// parent_id: nếu là câu hỏi thì để NULL; nếu là câu trả lời thì trỏ tới id của câu hỏi gốc.

// user_id: người tạo bản ghi (có thể là người hỏi hoặc người trả lời).

// content: nội dung câu hỏi hoặc câu trả lời.

// timestamps: tự động lưu thời gian tạo và cập nhật.

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions_answers');
    }
};
