<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipeStep
 *
 * Đây là model đại diện cho bảng `recipe_steps`.
 * - Dùng để quản lý các bước nấu ăn trong một recipe.
 * - Mỗi bước có thứ tự (step_order) và hướng dẫn (instruction).
 */
class RecipeStep extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - recipe_id: ID công thức
     * - step_order: thứ tự bước
     * - instruction: nội dung hướng dẫn
     */
    protected $fillable = ['recipe_id','step_order','instruction'];

    /**
     * Quan hệ n-1 với Recipe
     * Một bước nấu thuộc về một recipe.
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
