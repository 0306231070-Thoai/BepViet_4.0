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
        Schema::create('cookbook_details', function (Blueprint $table) {
            $table->unsignedBigInteger('cookbook_id'); // ID bộ sưu tập (FK → cookbooks.id)
            $table->unsignedBigInteger('recipe_id'); // ID công thức (FK → recipes.id)

            // Khóa ngoại
            $table->foreign('cookbook_id')->references('id')->on('cookbooks')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');

            // Khóa chính kép để đảm bảo duy nhất
            $table->primary(['cookbook_id', 'recipe_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookbook_details');
    }
};
