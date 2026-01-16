<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ingredient
 *
 * Đây là model đại diện cho bảng `ingredients`.
 * - Dùng để quản lý nguyên liệu chung.
 * - Một ingredient có thể xuất hiện trong nhiều recipe.
 */
class Ingredient extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - name: tên nguyên liệu
     */
    protected $fillable = ['name'];

    /**
     * Quan hệ 1-n với RecipeIngredient
     * Một ingredient có thể được dùng trong nhiều recipe.
     */
    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }
}
