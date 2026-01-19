<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required'
        ]);

        Category::create($request->only('name','description','type'));

        return response()->json(['message'=>'Category created']);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->only('name','description'));

        return response()->json(['message'=>'Category updated']);
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return response()->json(['message'=>'Category deleted']);
    }
}