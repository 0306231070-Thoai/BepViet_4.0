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
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->id(); // Mã bước thực hiện (PK)
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade'); // Công thức liên kết
            $table->integer('step_order'); // Thứ tự bước
            $table->text('instruction'); // Nội dung hướng dẫn
            $table->string('media_url')->nullable(); // Ảnh minh họa (không triển khai video)
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_steps');
    }
};
