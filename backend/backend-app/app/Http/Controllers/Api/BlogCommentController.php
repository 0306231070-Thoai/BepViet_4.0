<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    // ===== GET COMMENTS =====
    public function index($blogId)
    {
        $comments = BlogComment::with('user:id,username,avatar')
            ->where('blog_id', $blogId)
            ->latest()
            ->get();

        return response()->json($comments);
    }

    // ===== POST COMMENT =====
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $comment = BlogComment::create([
            'blog_id' => $id,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        return $comment->load('user:id,username,avatar');
    }

}
