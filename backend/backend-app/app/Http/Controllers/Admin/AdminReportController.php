<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class AdminReportController extends Controller
{
    public function index()
    {
        return Report::with('user','post')->paginate(10);
    }

    public function resolve($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'resolved';
        $report->save();

        return response()->json(['message'=>'Report resolved']);
    }

    public function reject($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'rejected';
        $report->save();

        return response()->json(['message'=>'Report rejected']);
    }
}