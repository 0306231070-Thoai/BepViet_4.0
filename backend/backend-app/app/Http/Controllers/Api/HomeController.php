<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe; // Chỉ import Recipe

class HomeController extends Controller
{
    public function index()
    {
        // 1. Lấy 8 Món ăn Mới nhất (New Arrivals)
        // Lưu ý: Select đúng các cột trong Model bạn gửi (title, main_image...)
        $newRecipes = Recipe::with('user:id,username') // Vẫn lấy info người tạo để hiển thị tên
                        ->select('id', 'user_id', 'title', 'main_image', 'cooking_time', 'difficulty', 'created_at')
                        ->where('status', 'Published') // Chỉ lấy món đã Public (theo comment trong Model)
                        ->latest()
                        ->take(8)
                        ->get();

        // 2. Lấy 4 Món ăn Ngẫu nhiên (Featured / Gợi ý hôm nay)
        $featuredRecipes = Recipe::with('user:id,username')
                        ->select('id', 'user_id', 'title', 'main_image', 'cooking_time', 'difficulty')
                        ->where('status', 'Published')
                        ->inRandomOrder()
                        ->take(4)
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'new_recipes' => $newRecipes,
                'featured_recipes' => $featuredRecipes,
            
            ]
        ], 200);
    }
}