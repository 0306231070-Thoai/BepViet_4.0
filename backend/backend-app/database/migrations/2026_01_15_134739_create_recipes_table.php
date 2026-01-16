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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id(); // Mã công thức (PK)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người đăng tải
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Danh mục
            $table->string('title'); // Tên món ăn
            $table->text('description')->nullable(); // Mô tả ngắn
            $table->string('main_image')->nullable(); // Hình ảnh chính
            $table->integer('cooking_time')->nullable(); // Thời gian chế biến (phút)
            $table->enum('difficulty', ['Easy', 'Medium', 'Hard'])->default('Easy'); // Mức độ khó
            $table->integer('servings')->nullable(); // Số khẩu phần
            $table->enum('status', ['Pending', 'Published', 'Hidden'])->default('Pending'); // Trạng thái công thức
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
