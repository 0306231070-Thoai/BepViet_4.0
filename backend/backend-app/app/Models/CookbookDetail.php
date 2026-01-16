<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CookbookDetail
 *
 * Đây là model đại diện cho bảng `cookbook_details`.
 * - Liên kết cookbook với recipe.
 * - Một cookbook có thể chứa nhiều recipe.
 */
class CookbookDetail extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - cookbook_id: ID của cookbook
     * - recipe_id: ID của recipe
     */
    protected $fillable = ['cookbook_id','recipe_id'];

    /** Quan hệ n-1 với Cookbook. */
    public function cookbook()
    {
        return $this->belongsTo(Cookbook::class);
    }

    /** Quan hệ n-1 với Recipe. */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
