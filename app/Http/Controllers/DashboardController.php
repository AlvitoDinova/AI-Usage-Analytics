<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\Project;
use App\Models\Assessment;
use App\Models\TopsisResult;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // 1. Get Top 1 AI tool that most frequently ranks 1
        $topRank1 = TopsisResult::where('ranking', 1)
            ->select('ai_id', DB::raw('count(*) as total_rank1'))
            ->groupBy('ai_id')
            ->orderBy('total_rank1', 'desc')
            ->first();
        
        $aiTerfavorit = '-';
        if ($topRank1) {
            $aiTool = AITool::find($topRank1->ai_id);
            if ($aiTool) {
                $aiTerfavorit = $aiTool->nama_ai . ' (' . $topRank1->total_rank1 . 'x)';
            }
        }

        // 2. Count Active Users
        $totalActiveUsers = User::where('status', 'active')->count();

        // 3. Count Draft projects
        $totalDraft = Project::where('status', 'Draft')->count();

        if ($user->role === 'admin') {
            // Eager count directly from database tables for real-time accuracy
            $totalAi = AITool::count();
            $totalCriteria = Criterion::count();
            $totalProyek = Project::count();
            $totalEvaluasi = Project::where('status', 'Selesai')->count();

            // Get last evaluated project details
            $lastEvaluatedProject = Project::where('status', 'Selesai')
                ->orderBy('updated_at', 'desc')
                ->first();

            $aiTerbaikTerakhir = '-';
            $proyekTerakhir = '-';

            if ($lastEvaluatedProject) {
                $proyekTerakhir = $lastEvaluatedProject->nama_proyek;

                // Get assessment for this project
                $assessment = Assessment::where('project_id', $lastEvaluatedProject->id)->orderBy('id', 'desc')->first();
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

            // Calculate evaluations count for the current month
            $evaluasiBulanIni = Assessment::whereMonth('tanggal_penilaian', now()->month)
                ->whereYear('tanggal_penilaian', now()->year)
                ->count();

            // Get Top 5 AI tools that most frequently rank 1
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
                'total_draft_proyek' => $totalDraft,
                'total_user_aktif' => $totalActiveUsers,
                'evaluasi_bulan_ini' => $evaluasiBulanIni,
                'ai_terbaik_terakhir' => $aiTerbaikTerakhir,
                'proyek_terakhir_dievaluasi' => $proyekTerakhir,
                'ai_terfavorit' => $aiTerfavorit,
            ];

            return view('user.dashboard', compact('stats', 'top5Ai'));
        } 
        
        if ($user->role === 'manager') {
            $totalProyek = Project::count();
            $totalEvaluasi = Project::where('status', 'Selesai')->count();

            // Get last evaluated project details
            $lastEvaluatedProject = Project::where('status', 'Selesai')
                ->orderBy('updated_at', 'desc')
                ->first();

            $aiTerbaikTerakhir = '-';
            $proyekTerakhir = '-';

            if ($lastEvaluatedProject) {
                $proyekTerakhir = $lastEvaluatedProject->nama_proyek;

                // Get assessment for this project
                $assessment = Assessment::where('project_id', $lastEvaluatedProject->id)->orderBy('id', 'desc')->first();
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

            $evaluasiBulanIni = Assessment::whereMonth('tanggal_penilaian', now()->month)
                ->whereYear('tanggal_penilaian', now()->year)
                ->count();

            $stats = [
                'total_proyek' => $totalProyek,
                'total_evaluasi' => $totalEvaluasi,
                'total_draft_proyek' => $totalDraft,
                'total_user_aktif' => $totalActiveUsers,
                'evaluasi_bulan_ini' => $evaluasiBulanIni,
                'ai_terbaik_terakhir' => $aiTerbaikTerakhir,
                'proyek_terakhir_dievaluasi' => $proyekTerakhir,
                'ai_terfavorit' => $aiTerfavorit,
            ];

            return view('manager.dashboard', compact('stats'));
        }

        // employee
        $totalProjects = Project::where('owner_id', $user->id)->count();
        $completedProjects = Project::where('owner_id', $user->id)->where('status', 'Selesai')->count();
        $pendingProjects = Project::where('owner_id', $user->id)->whereIn('status', ['Draft', 'Dinilai'])->count();

        $stats = [
            'total_projects' => $totalProjects,
            'completed_projects' => $completedProjects,
            'pending_projects' => $pendingProjects,
        ];

        return view('employee.dashboard', compact('stats', 'user'));
    }

    public function about(): View
    {
        return view('admin.about');
    }
}
