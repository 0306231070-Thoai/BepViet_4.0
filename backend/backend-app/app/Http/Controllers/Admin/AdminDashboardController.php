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

    public function traffic(Request $request)
    {
        // số ngày (mặc định 7)
        $range = $request->get('range', 7);

        $startDate = Carbon::now()->subDays($range - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // Khởi tạo mảng ngày
        $dates = collect();
        for ($i = 0; $i < $range; $i++) {
            $date = Carbon::now()
                ->subDays($range - 1 - $i)
                ->format('Y-m-d');

            $dates[$date] = 0;
        }

        // ===== POSTS =====
        $posts = DB::table('blogs')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('total', 'date');

        // ===== COMMENTS =====
        $comments = DB::table('comments')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('total', 'date');

        // ===== REPORTS =====
        $reports = DB::table('reports')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->pluck('total', 'date');

        // Gộp data
        foreach ($dates as $date => $value) {
            $dates[$date] =
                ($posts[$date] ?? 0) +
                ($comments[$date] ?? 0) +
                ($reports[$date] ?? 0);
        }

        // Chuẩn hóa cho frontend
        $labels = [];
        $data = [];

        foreach ($dates as $date => $total) {
            $labels[] = Carbon::parse($date)
                ->locale('vi')
                ->dayName;

            $data[] = $total;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}