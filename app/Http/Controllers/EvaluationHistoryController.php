<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Assessment;
use App\Models\TopsisResult;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluationHistoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $projectTypeId = $request->input('project_type_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $projectTypes = ProjectType::orderBy('nama_proyek', 'asc')->get();

        // Query assessments that have TOPSIS results, joining projects and project types
        $evaluations = Assessment::join('projects', 'assessments.project_id', '=', 'projects.id')
            ->join('project_types', 'projects.project_type_id', '=', 'project_types.id')
            ->select(
                'assessments.id as assessment_id',
                'assessments.tanggal_penilaian',
                'projects.id as project_id',
                'projects.nama_proyek',
                'projects.client',
                'project_types.nama_proyek as jenis_proyek'
            )
            ->whereHas('topsisResults')
            ->with(['topsisResults' => function ($q) {
                $q->orderBy('ranking', 'asc');
            }, 'topsisResults.aiTool'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('projects.nama_proyek', 'like', "%{$search}%")
                      ->orWhere('projects.client', 'like', "%{$search}%");
                });
            })
            ->when($projectTypeId, function ($query, $projectTypeId) {
                return $query->where('projects.project_type_id', $projectTypeId);
            })
            ->when($startDate, function ($query, $startDate) {
                return $query->where('assessments.tanggal_penilaian', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                return $query->where('assessments.tanggal_penilaian', '<=', $endDate);
            })
            ->orderBy('assessments.tanggal_penilaian', 'desc')
            ->orderBy('assessments.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.history.index', compact('evaluations', 'projectTypes', 'search', 'projectTypeId', 'startDate', 'endDate'));
    }

    public function show(Assessment $assessment): View|RedirectResponse
    {
        $assessment->load(['project.projectType', 'details.criterion', 'topsisResults.aiTool']);
        $project = $assessment->project;

        if (!$project) {
            return redirect()->route('history.index')
                ->with('error', 'Proyek terkait evaluasi ini tidak ditemukan.');
        }

        $results = $assessment->topsisResults()->orderBy('ranking', 'asc')->get();
        $bestAi = $results->first();

        $conclusion = "";
        if ($bestAi && $bestAi->aiTool) {
            $conclusion = "Berdasarkan analisis multikriteria menggunakan metode TOPSIS untuk proyek " . $project->nama_proyek . " (" . $project->projectType->nama_proyek . "), alternatif " . $bestAi->aiTool->nama_ai . " terpilih sebagai rekomendasi terbaik dengan nilai preferensi tertinggi sebesar " . number_format($bestAi->nilai_preferensi, 6) . ". Hal ini menunjukkan bahwa " . $bestAi->aiTool->nama_ai . " memiliki tingkat kecocokan yang paling optimal terhadap pembobotan kriteria proyek yang diinput oleh user.";
        }

        return view('admin.history.show', compact('project', 'assessment', 'results', 'bestAi', 'conclusion'));
    }

    public function exportPdf(Assessment $assessment)
    {
        $assessment->load(['project.projectType', 'details.criterion', 'topsisResults.aiTool']);
        $project = $assessment->project;

        if (!$project) {
            return redirect()->back()
                ->with('error', 'Proyek terkait evaluasi ini tidak ditemukan.');
        }

        $results = $assessment->topsisResults()->orderBy('ranking', 'asc')->get();
        $bestAi = $results->first();

        $conclusion = "";
        if ($bestAi && $bestAi->aiTool) {
            $conclusion = "Berdasarkan analisis multikriteria menggunakan metode TOPSIS untuk proyek " . $project->nama_proyek . " (" . $project->projectType->nama_proyek . "), alternatif " . $bestAi->aiTool->nama_ai . " terpilih sebagai rekomendasi terbaik dengan nilai preferensi tertinggi sebesar " . number_format($bestAi->nilai_preferensi, 6) . ". Hal ini menunjukkan bahwa " . $bestAi->aiTool->nama_ai . " memiliki tingkat kecocokan yang paling optimal terhadap pembobotan kriteria proyek yang diinput oleh user.";
        }

        // Record Activity Log
        ActivityLog::create([
            'aktivitas' => "Mengekspor hasil evaluasi proyek '{$project->nama_proyek}' ke PDF."
        ]);

        $pdf = Pdf::loadView('admin.history.pdf', compact('project', 'assessment', 'results', 'bestAi', 'conclusion'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_AInsight_' . str_replace(' ', '_', $project->nama_proyek) . '.pdf');
    }
}
