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
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade'); // Công thức liên kết
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người viết bình luận
            $table->text('content'); // Nội dung bình luận
            $table->tinyInteger('rating_star')->default(5); // Điểm đánh giá (1–5 sao)
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
