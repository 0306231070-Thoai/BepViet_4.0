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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Khóa chính
            $table->string('username')->unique(); // Tên đăng nhập duy nhất
            $table->string('email')->unique(); // Email duy nhất
            $table->string('password'); // Mật khẩu đã mã hóa
            $table->enum('role', ['member', 'admin'])->default('member'); // Vai trò người dùng
            $table->string('avatar')->nullable(); // Ảnh đại diện
            $table->text('bio')->nullable(); // Tiểu sử cá nhân
            $table->boolean('status')->default(true); // Trạng thái hoạt động (true = active, false = khóa)
            $table->timestamp('email_verified_at')->nullable(); // Thời điểm xác thực email
            $table->rememberToken(); // Token ghi nhớ đăng nhập
            $table->timestamps(); // Thời gian tạo và cập nhật
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
