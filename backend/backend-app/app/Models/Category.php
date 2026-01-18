<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * Model đại diện cho bảng `categories`
 * - Phân loại công thức (vùng miền, loại món, dịp lễ...)
 */

class Category extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - name: tên danh mục
     * - description: mô tả ngắn
     * - slug: đường dẫn thân thiện
     */
    protected $fillable = ['name', 'description', 'slug'];

    /** Một category có nhiều recipe */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
