<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ingredient
 *
 * Model đại diện cho bảng `ingredients`
 *  - Quản lý danh sách nguyên liệu chung
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
     * Một nguyên liệu có thể xuất hiện trong nhiều công thức
     * - Quan hệ nhiều–nhiều với Recipe
     * - Không quan tâm đến quantity, unit
     */

    /** Bảng trung gian lưu thông tin số lượng và đơn vị cho từng công thức,
     *  nên tui chỉ lấy pivot data ở phía Recipe để hiển thị chi tiết món ăn.
     *  Ở phía Ingredient, tui chỉ cần biết nguyên liệu đó xuất hiện trong những công thức nào nên không lấy thêm pivot.
     */
    public function recipes()
    {
        return $this->belongsToMany(
            Recipe::class,
            'recipe_ingredients',
            'ingredient_id',
            'recipe_id'
        );
    }
}
