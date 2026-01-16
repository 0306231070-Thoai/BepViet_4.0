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
            //$table->id();
            $table->unsignedBigInteger('recipe_id'); // ID công thức (FK → recipes.id)
            $table->unsignedBigInteger('ingredient_id'); // ID nguyên liệu (FK → ingredients.id)
            $table->decimal('quantity', 8, 2)->nullable(); // Số lượng nguyên liệu
            $table->string('unit')->nullable(); // Đơn vị đo (g, kg, thìa, bát…)

            // Khóa ngoại
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');

            // Khóa chính kép để đảm bảo duy nhất
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
