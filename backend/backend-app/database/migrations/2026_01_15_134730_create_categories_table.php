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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Mã danh mục (PK)
            $table->string('name'); // Tên danh mục (VD: Vùng miền, Loại món, Dịp lễ…)
            $table->text('description')->nullable(); // Mô tả danh mục
            $table->string('slug')->unique(); // Chuỗi định danh URL không dấu
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
