<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cookbook
 *
 * Model đại diện cho bảng `cookbooks`
 * - Bộ sưu tập công thức của user
 */

class Cookbook extends Model
{
    use HasFactory;

    /**
     * Các cột cho phép gán giá trị hàng loạt.
     * - name: tên cookbook
     * - description: mô tả ngắn
     */
    protected $fillable = ['name', 'description'];

    /** Cookbook thuộc về một user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Cookbook chứa nhiều recipe */
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
