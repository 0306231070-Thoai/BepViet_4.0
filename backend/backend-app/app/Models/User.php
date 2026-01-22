<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Blog;
use App\Models\BlogComment;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /* ================= ATTRIBUTES ================= */

    protected $fillable = [
        'username',
        'email',
        'password',
        'bio',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['avatar_url'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    /* ================= RELATIONS ================= */

    // Blog của user
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    // Comment blog
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    // Những người mình đang theo dõi
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'followed_id'
        );
    }

    // Những người theo dõi mình
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'followed_id',
            'follower_id'
        );
    }

    /* ================= ACCESSOR ================= */

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) return null;
        return asset('storage/' . $this->avatar);
    }
}
