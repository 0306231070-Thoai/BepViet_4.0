<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * ================= BLOG FEED (PUBLIC)
     * GET /api/blog-feed
     */
    public function feed()
    {
        return Blog::with([
                'user:id,username',
                'category:id,name'
            ])
            ->latest()
            ->paginate(5);
    }

    /**
     * ================= BLOG DETAIL (PUBLIC)
     * GET /api/blogs/{id}
     */
    public function show($id)
    {
        $blog = Blog::where('id', $id)
            ->where('status', 'Approved')
            ->first();

        if (!$blog) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($blog);
    }

    /**
     * ================= CREATE BLOG (AUTH)
     * POST /api/blogs
     */
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
