<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class AdminPostController extends Controller
{
    public function show($id)
    {
        $post = Blog::with([
                'user:id,username',
            ])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $post
        ], 200);
    }
    public function index()
    {
        return Blog::with('user')->paginate(10);
    }

    //PHE DUYET
    public function approve($id)
    {
        $post = Blog::findOrFail($id);
        $post->status = 'approved';
        $post->save();

        return response()->json(['message' => 'Post approved']);
    }

    // ✖ TỪ CHỐI
    public function reject($id)
    {
        $post = Blog::findOrFail($id);
        $post->status = 'rejected';
        $post->save();

        return response()->json(['message' => 'Post rejected']);
    }
    
}