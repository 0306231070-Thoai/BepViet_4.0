<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

/**
 * Class Blog
 *
 * Model đại diện cho bảng `blogs`.
 * - Quản lý bài viết chia sẻ của user.
 * - Bài viết chia sẻ kinh nghiệm nấu ăn.
 */
    

class Blog extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'image',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
