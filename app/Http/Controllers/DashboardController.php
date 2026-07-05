<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\Project;
use App\Models\Assessment;
use App\Models\TopsisResult;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Eager count directly from database tables for real-time accuracy
        $totalAi = AITool::count();
        $totalCriteria = Criterion::count();
        $totalProyek = Project::count();
        $totalEvaluasi = Project::where('status', 'Selesai')->count();

        // 1. Get last evaluated project details
        $lastEvaluatedProject = Project::where('status', 'Selesai')
            ->orderBy('updated_at', 'desc')
            ->first();

        $aiTerbaikTerakhir = '-';
        $proyekTerakhir = '-';

        if ($lastEvaluatedProject) {
            $proyekTerakhir = $lastEvaluatedProject->nama_proyek;

            // Get assessment for this project
            $assessment = Assessment::where('project_id', $lastEvaluatedProject->id)->first();
            if ($assessment) {
                $bestAi = TopsisResult::with('aiTool')
                    ->where('assessment_id', $assessment->id)
                    ->where('ranking', 1)
                    ->first();
                if ($bestAi && $bestAi->aiTool) {
                    $aiTerbaikTerakhir = $bestAi->aiTool->nama_ai;
                }
            }
        }

        // 2. Calculate evaluations count for the current month
        $evaluasiBulanIni = Assessment::whereMonth('tanggal_penilaian', now()->month)
            ->whereYear('tanggal_penilaian', now()->year)
            ->count();

        // 3. Get Top 5 AI tools that most frequently rank 1
        $top5Ai = TopsisResult::where('ranking', 1)
            ->select('ai_id', DB::raw('count(*) as total_rank1'))
            ->groupBy('ai_id')
            ->orderBy('total_rank1', 'desc')
            ->limit(5)
            ->with('aiTool')
            ->get();

        // Update statistics cache
        Statistic::where('nama_statistik', 'total_ai_tools')->update(['nilai' => $totalAi]);
        Statistic::where('nama_statistik', 'total_kriteria')->update(['nilai' => $totalCriteria]);
        Statistic::where('nama_statistik', 'total_proyek')->update(['nilai' => $totalProyek]);
        Statistic::where('nama_statistik', 'total_penilaian')->update(['nilai' => $totalEvaluasi]);

        $stats = [
            'total_ai_tools' => $totalAi,
            'total_kriteria' => $totalCriteria,
            'total_proyek' => $totalProyek,
            'total_evaluasi' => $totalEvaluasi,
            'ai_terbaik_terakhir' => $aiTerbaikTerakhir,
            'proyek_terakhir_dievaluasi' => $proyekTerakhir,
            'evaluasi_bulan_ini' => $evaluasiBulanIni,
        ];

        return view('user.dashboard', compact('stats', 'top5Ai'));
    }
}

