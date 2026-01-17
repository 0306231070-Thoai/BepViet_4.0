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
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // Mã báo cáo (PK)
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // Người gửi báo cáo (FK => users.id)
            $table->unsignedBigInteger('target_id'); // ID nội dung bị báo cáo (công thức, bài viết, bình luận, hỏi đáp)
            $table->enum('target_type', ['Recipe', 'Blog', 'Comment', 'QuestionAnswer']); // Loại nội dung bị báo cáo
            $table->text('reason')->nullable(); // Lý do vi phạm (lý do báo cáo)
            // Trạng thái xử lý báo cáo: chưa được xử lý / đã được admin xem xét / đã được xử lý xong
            $table->enum('status', ['Pending', 'Reviewed', 'Resolved'])->default('Pending');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
