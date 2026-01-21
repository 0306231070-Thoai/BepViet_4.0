<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function feed()
    {
        return response()->json(
            Blog::with([
                    'user:id,username,avatar',
                    'category:id,name'
                ])
                ->where('status', 'Approved')
                ->latest()
                ->paginate(5)
        );
    }

    // ===== BLOG DETAIL =====
    public function show($id)
    {
        $blog = Blog::with([
            'user:id,username,avatar',
            'comments.user:id,username,avatar'
        ])->find($id);

        if (!$blog) {
            return response()->json([
                'message' => 'Không tìm thấy bài viết'
            ], 404);
        }

        return response()->json($blog);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'image'       => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        $blog = Blog::create([
            'user_id'     => $request->user()->id,
            'title'       => $request->title,
            'excerpt'     => $request->excerpt ?? null,
            'content'     => $request->content,
            'image'       => $request->image,
            'category_id' => $request->category_id,
            'status'      => 'published', // hoặc pending
        ]);

        return response()->json([
            'message' => 'Tạo bài viết thành công',
            'data'    => $blog
        ], 201);
    }
}
