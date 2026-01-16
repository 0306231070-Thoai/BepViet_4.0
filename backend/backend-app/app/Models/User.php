<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * Đây là model đại diện cho bảng `users`.
 * - Dùng để quản lý thông tin người dùng (admin, member).
 * - Kế thừa từ Authenticatable để hỗ trợ đăng nhập/xác thực.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    /**
     * Các cột cho phép gán giá trị hàng loạt (mass assignment).
     * - username: tên đăng nhập
     * - email: địa chỉ email
     * - password: mật khẩu đã mã hóa
     * - role: vai trò (admin/member)
     * - bio: mô tả ngắn về người dùng
     * - status: trạng thái hoạt động (true/false)
     */
    protected $fillable = ['username', 'email', 'password', 'role', 'bio', 'status',];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    /**
     * Các cột sẽ bị ẩn khi serialize sang JSON.
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
            'status' => 'boolean',
        ];
    }

    /**
     * Quan hệ 1-n với Recipe
     * Một user có thể tạo nhiều công thức món ăn.
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Quan hệ 1-n với Comment
     * Một user có thể viết nhiều bình luận.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Quan hệ 1-n với Cookbook
     * Một user có thể sở hữu nhiều cookbook.
     */
    public function cookbooks()
    {
        return $this->hasMany(Cookbook::class);
    }

    /**
     * Quan hệ 1-n với Blog
     * Một user có thể viết nhiều bài blog.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Quan hệ 1-n với QuestionAnswer
     * Một user có thể đặt nhiều câu hỏi hoặc trả lời.
     */
    public function questions()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    /**
     * Quan hệ 1-n với Follow (người theo dõi mình)
     * Một user có thể có nhiều follower.
     */
    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    /**
     * Quan hệ 1-n với Follow (mình theo dõi người khác)
     * Một user có thể theo dõi nhiều người khác.
     */
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }
}
