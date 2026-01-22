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
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            // Khóa ngoại tới công thức - Xác định nguyên liệu thuộc công thức nào
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            // Khóa ngoại tới nguyên liệu - Xác định nguyên liệu được sử dụng
            $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
            $table->decimal('quantity', 8, 2); // Số lượng nguyên liệu cần dùng
            $table->string('unit'); // Đơn vị đo (g, kg, thìa, bát…)
            // Khóa chính kép để đảm bảo duy nhất (1 nguyên liệu chỉ xuất hiện 1 lần trong công thức)
            $table->primary(['recipe_id', 'ingredient_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
