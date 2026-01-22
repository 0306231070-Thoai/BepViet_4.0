<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // Danh sách recipe chờ duyệt
    public function pending()
    {
        $recipes = Recipe::with([
            'user:id,username',
            'category:id,name'
        ])
        ->where('status', 'Pending')
        ->latest()
        ->paginate(10);

        return response()->json($recipes);
    }

    // Danh sách recipe đã duyệt
public function published()
{
    return Recipe::with([
        'user:id,username',
        'category:id,name'
    ])
    ->where('status', 'Published')
    ->latest()
    ->paginate(10);
}

// Danh sách recipe bị ẩn / từ chối
public function hidden()
{
    return Recipe::with([
        'user:id,username',
        'category:id,name'
    ])
    ->where('status', 'Hidden')
    ->latest()
    ->paginate(10);
}

    // Duyệt recipe
    public function approve($id)
    {
        $recipe = Recipe::findOrFail($id);

        $recipe->update([
            'status' => 'Published'
        ]);

        return response()->json([
            'message' => 'Recipe đã được duyệt',
            'data' => $recipe
        ]);
    }

    // Từ chối recipe
}
