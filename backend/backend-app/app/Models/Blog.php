<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BlogComment;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'image',
        'status',
        'user_id',
        'category_id',
    ];

    protected $appends = ['image_url'];


    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'Ẩn danh',
            'avatar' => null,
        ]);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class)
                    ->latest();
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return asset('storage/' . $this->image);
    }
}
