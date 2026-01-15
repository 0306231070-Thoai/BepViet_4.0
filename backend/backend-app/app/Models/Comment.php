<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * Đây là model đại diện cho bảng `comments`.
 * - Dùng để quản lý bình luận của người dùng về recipe.
 */
class Comment extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - recipe_id: ID công thức
     * - user_id: ID người bình luận
     * - content: nội dung bình luận
     * - rating_star: số sao đánh giá
     */
    protected $fillable = ['recipe_id','user_id','content','rating_star'];

    /**
     * Quan hệ n-1 với Recipe
     * Một comment thuộc về một recipe.
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Quan hệ n-1 với User
     * Một comment thuộc về một user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
