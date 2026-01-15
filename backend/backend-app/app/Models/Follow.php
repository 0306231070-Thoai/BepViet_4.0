<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Follow
 *
 * Đây là model đại diện cho bảng `follows`.
 * - Dùng để quản lý quan hệ follow giữa người dùng.
 * - Một user có thể follow nhiều người khác, và cũng có nhiều follower.
 */
class Follow extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - follower_id: ID người theo dõi
     * - following_id: ID người được theo dõi
     */
    protected $fillable = ['follower_id','following_id'];

    /**
     * Quan hệ n-1 với User (người theo dõi).
     */
    public function follower()
    {
        return $this->belongsTo(User::class,'follower_id');
    }

    /**
     * Quan hệ n-1 với User (người được theo dõi).
     */
    public function following()
    {
        return $this->belongsTo(User::class,'following_id');
    }
}
