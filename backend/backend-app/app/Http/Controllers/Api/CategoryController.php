<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * =========================
     * LẤY DANH SÁCH DANH MỤC
     * =========================
     * - Trả về tất cả danh mục món ăn
     * - Dùng cho dropdown bên frontend
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    // Lấy chi tiết category + công thức thuộc category đó
    public function show($id)
    {
        $category = Category::with('recipes')->findOrFail($id);
        return response()->json($category);
    }
}
