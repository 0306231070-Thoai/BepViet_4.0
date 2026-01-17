<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cookbook
 *
 * Đây là model đại diện cho bảng `cookbooks`.
 * - Dùng để quản lý sổ tay nấu ăn của người dùng.
 * - Một user có thể có nhiều cookbook.
 */
class Cookbook extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - user_id: ID chủ sở hữu
     * - name: tên cookbook
     * - description: mô tả ngắn
     */
    protected $fillable = ['user_id','name','description'];

    /**
     * Quan hệ n-1 với User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ 1-n với CookbookDetail.
     * Một cookbook có thể chứa nhiều recipe.
     */
    public function recipes()
    {
        return $this->belongsToMany(
            Recipe::class,
            'cookbook_details',
            'cookbook_id',
            'recipe_id'
        );
    }
}
