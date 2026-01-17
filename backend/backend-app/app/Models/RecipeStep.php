<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipeStep
 *
 * Model đại diện cho bảng `recipe_steps`
 * - Lưu từng bước nấu ăn của công thức
 * - Mỗi bước có thứ tự (step_order) và hướng dẫn (instruction).
 */
class RecipeStep extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - step_order: thứ tự bước
     * - instruction: nội dung hướng dẫn
     * - media_url: ảnh minh họa (nếu có)
     */
    protected $fillable = ['step_order', 'instruction', 'media_url'];

    /** Bước nấu thuộc về một recipe */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
