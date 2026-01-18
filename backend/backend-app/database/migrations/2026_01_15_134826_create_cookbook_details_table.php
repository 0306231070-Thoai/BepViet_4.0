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
            // Khóa ngoại tới bộ sưu tập
            $table->foreignId('cookbook_id')->constrained('cookbooks')->onDelete('cascade'); 
             // Khóa ngoại tới công thức
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade'); 
            // Khóa chính kép để đảm bảo duy nhất - Mỗi công thức chỉ xuất hiện 1 lần trong 1 cookbook
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
