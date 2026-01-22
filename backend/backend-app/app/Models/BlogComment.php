<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Blog;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'blog_id',
        'user_id',
    ];

    /* ================= RELATION ================= */

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'Ẩn danh',
            'avatar' => null,
        ]);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
