<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 *
 * Model đại diện cho bảng `blogs`.
 * - Quản lý bài viết chia sẻ của user.
 * - Bài viết chia sẻ kinh nghiệm nấu ăn.
 */
    

class Blog extends Model
{
    use HasFactory;
    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - title: tiêu đề bài viết
     * - content: nội dung
     * - image: ảnh minh họa
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'status',
    ];
    /** Blog thuộc về một user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
    // Nếu sau này có comment
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
