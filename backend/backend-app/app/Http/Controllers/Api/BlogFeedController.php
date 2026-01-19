<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogFeedController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user(); // có thể null

    if ($user) {
        $followingIds = $user->following()->pluck('users.id')->toArray();
        $userIds = array_merge($followingIds, [$user->id]);
    } else {
        // Khách chưa login: chỉ xem blog Approved
        $userIds = [];
    }

    $blogs = Blog::where('status', 'Approved')
        ->when($user, function ($q) use ($userIds) {
            $q->whereIn('user_id', $userIds);
        })
        ->with('user:id,username,avatar')
        ->latest()
        ->paginate(10);

    return response()->json($blogs);
}

    // public function index(Request $request)
    // {
    //     $user = $request->user();

    //     // 1. Lấy danh sách ID người mình đang theo dõi
    //     $followingIds = $user->following()
    //         ->pluck('users.id') // đúng vì belongsToMany
    //         ->toArray();

    //     // 2. Gộp thêm ID của chính mình
    //     $userIds = array_merge($followingIds, [$user->id]);

    //     // 3. Lấy blog feed
    //     $blogs = Blog::whereIn('user_id', $userIds)
    //         ->where('status', 'Approved')
    //         ->with('user:id,username,avatar')
    //         ->latest()
    //         ->paginate(10);

    //     return response()->json($blogs);
    // }
}
