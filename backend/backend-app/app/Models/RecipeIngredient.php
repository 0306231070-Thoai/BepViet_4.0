<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RecipeIngredient
 *
 * Đây là model đại diện cho bảng `recipe_ingredients`.
 * - Liên kết recipe với ingredient.
 * - Lưu số lượng và đơn vị nguyên liệu cho từng recipe.
 */
class RecipeIngredient extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - recipe_id: ID công thức
     * - ingredient_id: ID nguyên liệu
     * - quantity: số lượng
     * - unit: đơn vị đo
     */
    protected $fillable = ['recipe_id','ingredient_id','quantity','unit'];

    /**
     * Quan hệ n-1 với Recipe
     * Một nguyên liệu thuộc về một recipe.
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    /**
     * Quan hệ n-1 với Ingredient
     * Một nguyên liệu thuộc về bảng ingredients.
     */
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
