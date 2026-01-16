<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 *
 * Đây là model đại diện cho bảng `blogs`.
 * - Quản lý bài viết chia sẻ của user.
 * - Một user có thể viết nhiều blog.
 */
class Blog extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - user_id: ID người viết
     * - title: tiêu đề bài viết
     * - content: nội dung
     * - image: ảnh minh họa
     * - status: trạng thái (Approved/Pending)
     */
    protected $fillable = ['user_id','title','content','image','status'];

    /** Quan hệ n-1 với User. */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
