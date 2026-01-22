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
     * Tạo mới một bộ sưu tập (Đã xóa bỏ xử lý ảnh để tránh lỗi SQL)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            // Đã xóa validate image ở đây
        ]);

        $cookbook = new Cookbook();
        $cookbook->name = $request->name;
        $cookbook->description = $request->description;
        $cookbook->user_id = Auth::id();
        
        // Đã xóa dòng $cookbook->image = ... vì CSDL không có cột này
        
        $cookbook->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã tạo bộ sưu tập mới',
            'data' => $cookbook
        ], 201);
    }

    /**
     * Lấy chi tiết bộ sưu tập.
     */
   /**
 * Lấy chi tiết bộ sưu tập.
 */
/**
 * Lấy chi tiết bộ sưu tập kèm danh sách món ăn.
 */
public function show($id) {
    $cookbook = Cookbook::withCount('recipes')
    ->with(['recipes' => function($query) {
        $query->select(
            'recipes.id',
            'recipes.title',
            'recipes.main_image',
            'recipes.cooking_time',
            'recipes.difficulty'
        );
    }])
    ->where('user_id', Auth::id())
    ->findOrFail($id);


    return response()->json(['status' => 'success', 'data' => $cookbook]);
}
    /**
     * Thêm công thức vào bộ sưu tập.
     */
    public function addRecipe(Request $request, $id)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);
        $cookbook = Cookbook::where('user_id', Auth::id())->findOrFail($id);
        $cookbook->recipes()->syncWithoutDetaching([$request->recipe_id]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm món ăn vào bộ sưu tập'
        ]);
    }

    public function removeRecipe($cookbookId, $recipeId)
    {
        $cookbook = Cookbook::where('user_id', Auth::id())->findOrFail($cookbookId);
        $cookbook->recipes()->detach($recipeId);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã gỡ món ăn khỏi bộ sưu tập'
        ]);
    }

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