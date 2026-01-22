<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserTraffic extends Controller
{
    public function userTraffic(Request $request)
{
    $range = $request->get('range', 7);

    $startDate = Carbon::now()->subDays($range - 1)->startOfDay();
    $endDate = Carbon::now()->endOfDay();

    // Tạo mảng ngày rỗng
    $dates = collect();
    for ($i = 0; $i < $range; $i++) {
        $date = Carbon::now()
            ->subDays($range - 1 - $i)
            ->format('Y-m-d');
        $dates[$date] = 0;
    }

    // Đếm user theo ngày
    $users = DB::table('users')
        ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('date')
        ->pluck('total', 'date');

    // Gộp data
    foreach ($dates as $date => $value) {
        $dates[$date] = $users[$date] ?? 0;
    }

    // Chuẩn hóa cho frontend
    $labels = [];
    $data = [];

    foreach ($dates as $date => $total) {
        $labels[] = Carbon::parse($date)->locale('vi')->dayName;
        $data[] = $total;
    }

    return response()->json([
        'labels' => $labels,
        'data' => $data,
    ]);
}

}
