<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->longText('content');

            // Ảnh bài viết (lưu path: blogs/xxx.jpg)
            $table->string('image')->nullable();

            // TRẠNG THÁI BLOG (QUAN TRỌNG)
            $table->enum('status', ['draft', 'published'])
                  ->default('published');

            // USER & CATEGORY
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
