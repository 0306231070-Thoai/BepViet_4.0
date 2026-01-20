<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogFeedController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::where('status', 'Approved')
            ->with([
                'user:id,username,avatar',
                'category:id,name'
            ])
            ->latest()
            ->paginate(5);

        return response()->json($blogs);
    }
}
