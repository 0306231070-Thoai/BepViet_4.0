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
            
            // ID người theo dõi (FK => users.id) => xóa user thì tự xóa follow liên quan
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');

            // ID người được theo dõi (FK => users.id) => xóa user thì tự xóa follow liên quan
            $table->foreignId('following_id')->constrained('users')->onDelete('cascade');

            // Khóa chính kép để đảm bảo duy nhất - 1 người chỉ có thể follow 1 người khác duy nhất 1 lần
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
