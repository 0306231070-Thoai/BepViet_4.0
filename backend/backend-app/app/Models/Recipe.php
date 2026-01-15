<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Recipe
 *
 * Đây là model đại diện cho bảng `recipes`.
 * - Dùng để quản lý công thức món ăn.
 * - Liên kết với user (người tạo) và category (danh mục).
 */
class Recipe extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - user_id: ID người tạo
     * - category_id: ID danh mục
     * - title: tên món ăn
     * - description: mô tả món ăn
     * - main_image: ảnh chính
     * - cooking_time: thời gian nấu
     * - difficulty: độ khó (Easy/Medium/Hard)
     * - servings: số khẩu phần
     * - status: trạng thái (Published/Draft)
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'main_image',
        'cooking_time',
        'difficulty',
        'servings',
        'status'
    ];

    /**
     * Quan hệ n-1 với User
     * Một recipe thuộc về một user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ n-1 với Category
     * Một recipe thuộc về một category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Quan hệ 1-n với RecipeStep
     * Một recipe có nhiều bước nấu.
     */
    public function steps()
    {
        return $this->hasMany(RecipeStep::class);
    }

    /**
     * Quan hệ 1-n với RecipeIngredient
     * Một recipe có nhiều nguyên liệu.
     */
    public function ingredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * Quan hệ 1-n với Comment
     * Một recipe có nhiều bình luận.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
