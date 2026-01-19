<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Tạo blog
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|string', // hoặc file nếu sau này upload
        ]);

        $blog = Blog::create([
            'user_id' => $request->user()->id,
            'title'   => $request->title,
            'content' => $request->content,
            'image'   => $request->image,
            'status'  => 'Pending', // admin duyệt
        ]);

        return response()->json([
            'message' => 'Tạo bài viết thành công, chờ duyệt',
            'data' => $blog
        ], 201);
    }

    // Xem chi tiết blog
    public function show($id)
    {
        $blog = Blog::with('user:id,username,avatar')
            ->where('status', 'Approved')
            ->findOrFail($id);

        return response()->json($blog);
    }
}
