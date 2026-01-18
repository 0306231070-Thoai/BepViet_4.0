<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 1. THÊM DÒNG NÀY


/**
 * Class User
 *
 * Model đại diện cho bảng `users`
 * - Quản lý thông tin người dùng (member / admin)
 * - Hỗ trợ xác thực đăng nhập (kế thừa Authenticatable)
 */


class User extends Authenticatable
{
    // 2. THÊM HasApiTokens VÀO DANH SÁCH USE DƯỚI ĐÂY
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     */


    /**
     * Các cột cho phép gán giá trị hàng loạt (mass assignment).
     * - username: tên đăng nhập
     * - email: địa chỉ email
     * - password: mật khẩu đã mã hóa
     * - bio: mô tả ngắn về người dùng
     * - avatar: ảnh đại diện
     */
<<<<<<< Updated upstream
    protected $fillable = ['username', 'email', 'password', 'bio', 'avatar']; // Nên thêm avatar nếu bạn có dùng trong AuthController
=======
    // Nên thêm avatar nếu có dùng trong AuthController
    protected $fillable = ['username', 'email', 'password', 'bio', 'avatar'];
>>>>>>> Stashed changes
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    /**
     * Các cột sẽ bị ẩn khi trả về sang JSON.
     * - password: không hiển thị mật khẩu
     * - remember_token: token ghi nhớ đăng nhập
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**

     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    /**
     * Ép kiểu dữ liệu cho các cột.
     * - email_verified_at: kiểu datetime
     * - password: tự động hash khi gán
     * - status: ép thành boolean (true/false)

     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean', // Khớp với TinyInt (1 = true, 0 = false)
        ];
    }


    /** Một user có thể đăng nhiều công thức */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /** Một user có thể viết nhiều bình luận */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /** Một user có thể tạo nhiều cookbook */
    public function cookbooks()
    {
        return $this->hasMany(Cookbook::class);
    }

    /** Một user có thể viết nhiều blog */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /** Một user có thể hỏi hoặc trả lời nhiều câu hỏi */
    public function questionAnswers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    /** Danh sách người theo dõi user này */
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    /** Danh sách user mà user này đang theo dõi */
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }
}
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
