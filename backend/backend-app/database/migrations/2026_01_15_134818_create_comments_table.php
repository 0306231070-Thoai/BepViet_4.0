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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Mã bình luận (PK)
            // Công thức được bình luận (FK => recipes.id)
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            // Người viết bình luận (FK =. users.id)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content'); // Nội dung bình luận
            // --- Đánh giá công thức ---
            // NULL: Người dùng chỉ bình luận, không đánh giá
            // 1 – 5 sao: Mức độ hài lòng với công thức
            $table->tinyInteger('rating_star')->nullable();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
