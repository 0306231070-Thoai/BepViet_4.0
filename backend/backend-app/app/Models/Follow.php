<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Follow
 *
 * Model đại diện cho bảng `follows`
 * - Quản lý quan hệ theo dõi giữa user
 * - Một user có thể follow nhiều người khác, và cũng có nhiều follower.
 */

class Follow extends Model
{

    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - following_id: người được theo dõi
     */
    protected $fillable = ['following_id'];

    /** User thực hiện follow */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /** User được follow */
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
