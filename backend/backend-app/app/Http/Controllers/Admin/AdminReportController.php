<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Blog;
use App\Models\Recipe;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with([
            'sender',
            'target' => function ($morph) {
                $morph->morphWith([
                    Comment::class => ['user', 'recipe'],
                    Blog::class => ['user'],
                    Recipe::class => ['user'],
                ]);
            }
        ])->paginate(10);

        return response()->json($reports);
    }

    // BƯỚC 1: Admin bắt đầu xem
    public function review($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'reviewed';
        $report->save();

        return response()->json(['message' => 'Report reviewed']);
    }

    // BƯỚC 2: Xử lý xong
    public function resolve($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'resolved';
        $report->save();

        return response()->json(['message' => 'Report resolved']);
    }
}
