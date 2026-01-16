<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * Đây là model đại diện cho bảng `categories`.
 * - Dùng để quản lý danh mục món ăn (Miền Bắc, Miền Trung, Miền Nam).
 * - Một category có thể chứa nhiều recipe.
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - name: tên danh mục
     * - description: mô tả ngắn
     * - slug: đường dẫn thân thiện
     */
    protected $fillable = ['name', 'description', 'slug'];

    /**
     * Quan hệ 1-n với Recipe
     * Một category có thể có nhiều recipe.
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
