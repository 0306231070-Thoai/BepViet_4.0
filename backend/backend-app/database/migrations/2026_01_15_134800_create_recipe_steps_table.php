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
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->id(); // Mã bước thực hiện (PK)
            // Khóa ngoại liên kết tới bảng recipes - Khi xóa công thức => tự động xóa toàn bộ các bước
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade'); // Xác định bước này thuộc về công thức nào
            $table->integer('step_order'); // Thứ tự bước nấu - Dùng để sắp xếp các bước theo đúng trình tự (1, 2, 3…)
            // Đảm bảo trong cùng một công thức: Ko có 2 bước trùng thứ tự - Mỗi step_order chỉ xuất hiện một lần
            $table->unique(['recipe_id', 'step_order']); //  Ràng buộc duy nhất
            $table->text('instruction'); // Nội dung hướng dẫn chi tiết
            // Ảnh minh họa cho bước (không triển khai video)
            $table->string('media_url')->nullable(); // Cho phép null vì không phải bước nào cũng cần hình ảnh
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_steps');
    }
};
