<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    // GET /blogs/{id}/comments
    public function index($id)
    {
        $comments = BlogComment::where('blog_id', $id)
            ->with('user:id,username,avatar')
            ->latest()
            ->get();

        return response()->json($comments);
    }

    // POST /blogs/{id}/comments
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = BlogComment::create([
            'content' => $request->content,
            'blog_id' => $id,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Bình luận thành công',
            'data' => $comment->load('user'),
        ], 201);
    }
}

