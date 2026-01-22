<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function feed(Request $request)
    {
        $search = $request->query('search');

        $blogs = Blog::with(['user:id,username,avatar'])
            ->where('status', 'published')
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            })
            ->latest()
            ->paginate(5);

        return response()->json($blogs);
    }



    public function show($id)
    {
        $blog = Blog::with([
            'user:id,username,avatar',
            'comments.user:id,username,avatar'
        ])
        ->where('id', $id)
        ->where('status', 'published')
        ->first();

        if (!$blog) {
            return response()->json(['message' => 'Không tìm thấy bài viết'], 404);
        }

        $blog->user->is_following = Auth::check()
            ? Auth::user()
                ->following()
                ->where('followed_id', $blog->user->id)
                ->exists()
            : false;

        return response()->json($blog);
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'title'   => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'image'   => $imagePath,
            'status'  => 'published', 
            'user_id' => Auth::id(),
        ]);

        return response()->json($blog, 201);
    }

    
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'nullable|in:draft,published',
        ]);

        $data = $request->only([
            'title',
            'excerpt',
            'content',
            'category_id',
            'status'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return response()->json($blog);
    }

    /**
     * =========================
     * DELETE BLOG
     * DELETE /api/blogs/{id}
     * =========================
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Không tìm thấy blog'], 404);
        }

        if ($blog->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền'], 403);
        }

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json([
            'message' => 'Xóa blog thành công'
        ]);
    }
}
