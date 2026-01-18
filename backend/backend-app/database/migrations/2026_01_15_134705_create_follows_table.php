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
        Schema::create('follows', function (Blueprint $table) {
            //$table->id();
            $table->unsignedBigInteger('follower_id'); // Người theo dõi (FK → users.id)
            $table->unsignedBigInteger('following_id'); // Người được theo dõi (FK → users.id)

            // Khóa ngoại
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('following_id')->references('id')->on('users')->onDelete('cascade');

            // Khóa chính kép để đảm bảo duy nhất
            $table->primary(['follower_id', 'following_id']);

            // Nếu muốn lưu thêm thời gian follow
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
