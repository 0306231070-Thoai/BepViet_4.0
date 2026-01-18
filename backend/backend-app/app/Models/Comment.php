<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 *
 * Model đại diện cho bảng `comments`
 * - Bình luận và đánh giá công thức
 */

class Comment extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - content: nội dung bình luận
     * - rating_star: số sao đánh giá (1–5)
     */
    protected $fillable = ['content', 'rating_star'];

    /** Bình luận thuộc về một recipe */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    /** Bình luận thuộc về một user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
