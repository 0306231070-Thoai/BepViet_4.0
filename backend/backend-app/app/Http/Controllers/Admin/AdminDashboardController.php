<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use App\Models\Report;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_posts' => Blog::count(),
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status','pending')->count(),
        ]);
    }
}