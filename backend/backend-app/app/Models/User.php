<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 1. THÊM DÒNG NÀY

class User extends Authenticatable
{
    // 2. THÊM HasApiTokens VÀO DANH SÁCH USE DƯỚI ĐÂY
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     */
    protected $fillable = [
        'username', 
        'email', 
        'password', 
        'role', 
        'bio', 
        'status',
        'avatar', // Nên thêm avatar nếu bạn có dùng trong AuthController
    ];

    /**
     * Các cột bị ẩn khi trả về JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean', // Khớp với TinyInt (1 = true, 0 = false)
        ];
    }

    // Các quan hệ recipes, comments, cookbooks... giữ nguyên như code của bạn
    public function recipes() { return $this->hasMany(Recipe::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function cookbooks() { return $this->hasMany(Cookbook::class); }
    public function blogs() { return $this->hasMany(Blog::class); }
    public function questions() { return $this->hasMany(QuestionAnswer::class); }
    public function followers() { return $this->hasMany(Follow::class, 'following_id'); }
    public function following() { return $this->hasMany(Follow::class, 'follower_id'); }
}