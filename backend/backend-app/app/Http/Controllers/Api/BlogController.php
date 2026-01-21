<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Tạo blog
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'title'       => $request->title,
            'excerpt'     => Str::limit(strip_tags($request->content), 150),
            'content'     => $request->content,
            'image'       => $imagePath,
            'status'      => 'Approved',
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
        ]);

        // Load quan hệ để React dùng ngay
        $blog->load([
            'user:id,username,avatar',
            'category:id,name'
        ]);

        return response()->json($blog, 201);
    }

    /**
     * Chi tiết blog + comments
     */
    public function show($id)
    {
        $blog = Blog::with([
            'user:id,username,avatar',
            'category:id,name',
            'comments' => function ($q) {
                $q->latest();
            },
            'comments.user:id,username,avatar'
        ])->findOrFail($id);

        return response()->json($blog);
    }

    /**
     * Blog feed
     */
    public function feed(Request $request)
    {
        $query = Blog::with(['user:id,username', 'category:id,name'])
            ->where('status', 'Approved');

        // 🔍 SEARCH theo title + content
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $blogs = $query->latest()->paginate(5);

        return response()->json($blogs);
    }
    /**
     * Blog feed từ những người mình follow
     */
    public function followingFeed()
    {
        $followingIds = auth()->user()->following()->pluck('users.id');

        $blogs = Blog::with('user:id,username,avatar')
            ->whereIn('user_id', $followingIds)
            ->where('status', 'Approved')
            ->latest()
            ->paginate(5);

        return response()->json($blogs);
    }

}
