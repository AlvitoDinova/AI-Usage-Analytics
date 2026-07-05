<?php

namespace App\Http\Controllers;

use App\Models\AITool;
use App\Models\Project;
use App\Models\Assessment;
use App\Models\ProjectType;
use App\Models\TopsisResult;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(): View
    {
        // 1. AI Tool ranked 1 count (AI Paling Sering Ranking 1)
        $aiRank1Counts = TopsisResult::where('ranking', 1)
            ->select('ai_id', DB::raw('count(*) as count'))
            ->groupBy('ai_id')
            ->orderBy('count', 'desc')
            ->with('aiTool')
            ->get();

        // 2. Total evaluations per AI (Jumlah evaluasi per AI tool)
        $aiEvaluationCounts = TopsisResult::select('ai_id', DB::raw('count(*) as count'))
            ->groupBy('ai_id')
            ->orderBy('count', 'desc')
            ->with('aiTool')
            ->get();

        // 3. Project breakdown by type
        $projectsByType = ProjectType::withCount('projects')
            ->orderBy('projects_count', 'desc')
            ->get();

        // 4. Overall stats
        $totalProjects = Project::count();
        $totalAi = AITool::count();
        $totalEvaluations = Assessment::has('topsisResults')->count();
        
        // Calculate average AI tools evaluated per project
        $avgAiPerProject = DB::table('project_ai_tools')
            ->select(DB::raw('count(ai_tool_id) as total_mappings, count(distinct project_id) as total_projects'))
            ->first();

        $avgAi = 0;
        if ($avgAiPerProject && $avgAiPerProject->total_projects > 0) {
            $avgAi = $avgAiPerProject->total_mappings / $avgAiPerProject->total_projects;
        }

        return view('admin.statistics.index', compact(
            'aiRank1Counts',
            'aiEvaluationCounts',
            'projectsByType',
            'totalProjects',
            'totalAi',
            'totalEvaluations',
            'avgAi'
        ));
    }
}
