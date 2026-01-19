<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class AdminPostController extends Controller
{
    public function index()
    {
        return Blog::with('user')->paginate(10);
    }

    public function approve($id)
    {
        $post = Blog::findOrFail($id);
        $post->status = 'published';
        $post->save();

        return response()->json(['message'=>'Post approved']);
    }

    public function destroy($id)
    {
        Blog::destroy($id);
        return response()->json(['message'=>'Post deleted']);
    }
}