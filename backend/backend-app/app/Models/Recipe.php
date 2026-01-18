<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Recipe
 *
 * Model đại diện cho bảng `recipes`
 * - Lưu thông tin công thức món ăn
 */

class Recipe extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - category_id: danh mục
     * - title: tên món ăn
     * - description: mô tả món ăn
     * - main_image: ảnh chính
     * - cooking_time: thời gian nấu (phút)
     * - difficulty: độ khó (Easy/Medium/Hard)
     * - servings: số khẩu phần
     */

    /**
     * Tui chỉ cho vào $fillable những cột mà người dùng được phép nhập.
     * Các khóa ngoại như user_id, sender_id, follower_id đều do hệ thống xác định 
     * dựa trên người đang đăng nhập nên tui không cho gán hàng loạt để tránh lỗi bảo mật.
     */

    /* category_id là dữ liệu nghiệp vụ do người dùng chọn khi tạo công thức.
     * Khác với user_id và status là do hệ thống quản lý nên tui cho phép 
     * gán hàng loạt category_id để thuận tiện khi tạo công thức.
     */

    /**
     * Khi tạo công thức:
     * User bắt buộc phải chọn danh mục
     * Không có category => công thức vô nghĩa
     * Category là dữ liệu nghiệp vụ, không phải dữ liệu bảo mật
     */
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'main_image',
        'cooking_time',
        'difficulty',
        'servings',
    ];

    /** Công thức thuộc về một user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Công thức thuộc về một category */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** Một công thức có nhiều bước nấu */
    public function steps()
    {
        return $this->hasMany(RecipeStep::class);
    }

    /**
     * Một công thức có nhiều nguyên liệu
     * - Lấy thêm quantity, unit từ bảng trung gian
     */

    /**
     * Lý do thiết kế:
     * - Nguyên liệu là dữ liệu dùng chung (ví dụ: muối, đường, trứng...)
     * - Số lượng và đơn vị không cố định, mà thay đổi theo từng công thức
     * - Vì vậy quantity và unit không đặt trong bảng ingredients
     *   mà đặt trong bảng trung gian `recipe_ingredients` 
     */


    public function ingredients()

    {
        return $this->belongsToMany(
            Ingredient::class,
            'recipe_ingredients',
            'recipe_id',
            'ingredient_id'
        )->withPivot('quantity', 'unit');
    }


    /** Một công thức có nhiều bình luận */

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    /** Một công thức có thể nằm trong nhiều cookbook */
    public function cookbooks()
    {
        return $this->belongsToMany(
            Cookbook::class,
            'cookbook_details',
            'recipe_id',
            'cookbook_id'
        );

    }

}
