<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    
    public function index($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json([], 200);
        }

        $comments = BlogComment::with('user:id,username,avatar')
            ->where('blog_id', $id)
            ->latest()
            ->get();

        return response()->json($comments);
    }

    
    public function store(Request $request, $id)
    {
       
        if (!Auth::check()) {
            return response()->json(['message' => 'Chưa đăng nhập'], 401);
        }

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:1000',
        ]);

        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog không tồn tại'], 404);
        }

        $comment = BlogComment::create([
            'content' => $validated['content'],
            'blog_id' => $blog->id,
            'user_id' => Auth::id(),
        ]);

        $comment->load('user:id,username,avatar');

        return response()->json($comment, 201);
    }

    
    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Chưa đăng nhập'], 401);
        }

        $comment = BlogComment::find($id);
        if (!$comment) {
            return response()->json(['message' => 'Comment không tồn tại'], 404);
        }

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Đã xóa comment']);
    }
}
