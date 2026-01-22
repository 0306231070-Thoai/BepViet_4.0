<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;              // ✅ FIX Request
use Illuminate\Support\Facades\DB;         // ✅ FIX DB
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\Blog;
use App\Models\Report;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'total_users' => User::count(),

            // Chỉ đếm công thức đã đăng
            'total_recipes' => Recipe::where('status', 'Published')->count(),

            // Bài viết chờ duyệt
            'pending_posts' => Blog::where('status', 'pending')->count(),

            'total_comments' => Comment::count(),

            // Tổng báo cáo
            'total_reports' => Report::count(),
        ]);
    }
}