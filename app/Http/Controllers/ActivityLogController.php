<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $activityType = $request->input('activity_type');

        $query = ActivityLog::query();

        // 1. Search text
        if ($search) {
            $query->where('aktivitas', 'like', "%{$search}%");
        }

        // 2. Date filters (handle start/end dates for timestamp created_at)
        if ($startDate) {
            $query->where('created_at', '>=', "{$startDate} 00:00:00");
        }
        if ($endDate) {
            $query->where('created_at', '<=', "{$endDate} 23:59:59");
        }

        // 3. Activity type filters mapping to descriptive text fragments
        if ($activityType) {
            $query->where(function ($q) use ($activityType) {
                switch ($activityType) {
                    case 'project':
                        $q->where('aktivitas', 'like', '%proyek%');
                        break;
                    case 'ai_tool':
                        $q->where('aktivitas', 'like', '%AI Tool%')
                          ->orWhere('aktivitas', 'like', '%alternatif%');
                        break;
                    case 'mapping':
                        $q->where('aktivitas', 'like', '%pemetaan%');
                        break;
                    case 'matrix':
                        $q->where('aktivitas', 'like', '%matriks%');
                        break;
                    case 'topsis':
                        $q->where('aktivitas', 'like', '%TOPSIS%');
                        break;
                    case 'pdf':
                        $q->where('aktivitas', 'like', '%PDF%');
                        break;
                }
            });
        }

        // 4. Order by latest
        $logs = $query->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.activity_logs.index', compact('logs', 'search', 'startDate', 'endDate', 'activityType'));
    }
}
