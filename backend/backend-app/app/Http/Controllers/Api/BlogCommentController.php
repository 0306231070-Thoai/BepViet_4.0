<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index($blogId)
    {
        $comments = BlogComment::with('user:id,username,avatar')
            ->where('blog_id', $blogId)
            ->latest()
            ->get();

        return response()->json($comments);
    }


    public function store(Request $request, $blogId)
    {
        $request->validate([
            'content' => 'required|min:2'
        ]);

        $comment = BlogComment::create([
            'blog_id' => $blogId,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        return response()->json(
            $comment->load('user:id,username,avatar'),
            201
        );
    }
    
}
