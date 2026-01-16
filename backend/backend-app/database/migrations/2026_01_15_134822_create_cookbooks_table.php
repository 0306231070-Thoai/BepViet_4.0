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
        Schema::create('cookbooks', function (Blueprint $table) {
            $table->id(); // Mã bộ sưu tập (PK)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Chủ sở hữu
            $table->string('name'); // Tên bộ sưu tập
            $table->text('description')->nullable(); // Mô tả bộ sưu tập
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookbooks');
    }
};
