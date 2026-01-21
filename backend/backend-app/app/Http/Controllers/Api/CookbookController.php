<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cookbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CookbookController extends Controller
{
    /**
     * Lấy danh sách bộ sưu tập của người dùng hiện tại.
     */
    public function index()
    {
        // Sử dụng Auth::id() để chỉ lấy bộ sưu tập của người đang đăng nhập
        // Đếm số lượng công thức bên trong mỗi bộ sưu tập (recipes_count)
        $cookbooks = Cookbook::withCount('recipes')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $cookbooks
        ]);
    }

    /**
     * Tạo mới một bộ sưu tập với hình ảnh được chọn sẵn.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|string', // Chấp nhận tên file ảnh có sẵn từ frontend
        ]);

        $cookbook = new Cookbook();
        $cookbook->name = $request->name;
        $cookbook->description = $request->description;
        $cookbook->user_id = Auth::id();
        
        // Lưu tên file ảnh (ví dụ: 'ansang.png'), nếu không gửi thì dùng mặc định
        $cookbook->image = $request->image ?? 'macdinh.png'; 
        
        $cookbook->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã tạo bộ sưu tập mới',
            'data' => $cookbook
        ], 201);
    }

    /**
     * Lấy chi tiết bộ sưu tập và danh sách món ăn bên trong.
     */
    public function show($id)
    {
        // Eager load recipes và thông tin người tạo công thức (nếu cần)
        $cookbook = Cookbook::with(['recipes' => function($query) {
            $query->select('recipes.id', 'recipes.title', 'recipes.image', 'recipes.description');
        }])
        ->where('user_id', Auth::id())
        ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $cookbook
        ]);
    }



    
    /**
     * Thêm một công thức vào bộ sưu tập (quan hệ n-n).
     */
    public function addRecipe(Request $request, $id)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);

        $cookbook = Cookbook::where('user_id', Auth::id())->findOrFail($id);

        // syncWithoutDetaching giúp tránh lỗi Integrity constraint violation nếu add trùng
        $cookbook->recipes()->syncWithoutDetaching([$request->recipe_id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm món ăn vào bộ sưu tập'
        ]);
    }

    /**
     * Xóa công thức khỏi bộ sưu tập.
     */
    public function removeRecipe($cookbookId, $recipeId)
    {
        $cookbook = Cookbook::where('user_id', Auth::id())->findOrFail($cookbookId);
        $cookbook->recipes()->detach($recipeId);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã gỡ món ăn khỏi bộ sưu tập'
        ]);
    }

    /**
     * Xóa toàn bộ bộ sưu tập.
     */
    public function destroy($id)
    {
        $cookbook = Cookbook::where('user_id', Auth::id())->findOrFail($id);
        $cookbook->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa bộ sưu tập'
        ]);
    }
}