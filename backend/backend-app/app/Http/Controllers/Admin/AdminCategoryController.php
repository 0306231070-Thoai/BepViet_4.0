<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return response()->json(
            Category::orderBy('id', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Tạo slug tự động từ name
        $data['slug'] = Str::slug($data['name']);

        // Đảm bảo slug không trùng
        if (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . time();
        }

        $category = Category::create($data);

        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::with('recipes')->findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update slug theo name mới
        $slug = Str::slug($data['name']);
        if (
            Category::where('slug', $slug)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            $slug .= '-' . time();
        }

        $data['slug'] = $slug;

        $category->update($data);

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
