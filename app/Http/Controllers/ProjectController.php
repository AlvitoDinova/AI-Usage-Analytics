<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Statistic;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\MatrixValue;
use App\Models\ActivityLog;
use App\Models\Assessment;
use App\Models\TopsisResult;
use App\Models\CalculationLog;
use App\Http\Requests\StoreProjectRequest;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    private function updateStatsCache(): void
    {
        Statistic::where('nama_statistik', 'total_proyek')
            ->update(['nilai' => Project::count()]);

        $totalPenilaian = Project::where('status', 'Dinilai')->orWhere('status', 'Selesai')->count();
        Statistic::where('nama_statistik', 'total_penilaian')
            ->update(['nilai' => $totalPenilaian]);
    }

    public function index(Request $request): View
    {
        $search = $request->input('search');

        $projects = Project::with('projectType')
            ->when($search, function ($query, $search) {
                return $query->where('nama_proyek', 'like', "%{$search}%")
                             ->orWhere('client', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.projects.index', compact('projects', 'search'));
    }

    public function create(): View
    {
        $projectTypes = ProjectType::orderBy('nama_proyek', 'asc')->get();
        $allAiTools = AITool::where('status', 'aktif')->orderBy('nama_ai', 'asc')->get();
        return view('admin.projects.create', compact('projectTypes', 'allAiTools'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create($request->validated());
        $project->aiTools()->sync($request->input('ai_tools', []));
        $this->updateStatsCache();

        ActivityLog::create([
            'aktivitas' => "Membuat proyek baru: '{$project->nama_proyek}'."
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Data Proyek baru berhasil ditambahkan.');
    }

    public function show(Project $project): View
    {
        $project->load('projectType');
        
        // Fetch project-specific AI Tools and Criteria to build the Decision Matrix representation
        $aiTools = $project->aiTools()->orderBy('id', 'asc')->get();
        $criteria = Criterion::orderBy('id', 'asc')->get();
        
        // Fetch raw matrix scores to show inside the details view isolated by project
        $matrixScores = MatrixValue::where('project_id', $project->id)->get()->groupBy('ai_id');

        return view('admin.projects.show', compact('project', 'aiTools', 'criteria', 'matrixScores'));
    }

    public function edit(Project $project): View
    {
        $projectTypes = ProjectType::orderBy('nama_proyek', 'asc')->get();
        $allAiTools = AITool::where('status', 'aktif')->orderBy('nama_ai', 'asc')->get();
        $selectedAiIds = $project->aiTools->pluck('id')->toArray();
        return view('admin.projects.edit', compact('project', 'projectTypes', 'allAiTools', 'selectedAiIds'));
    }

    public function update(StoreProjectRequest $request, Project $project): RedirectResponse
    {
        $oldAiIds = $project->aiTools->pluck('id')->toArray();
        $newAiIds = array_map('intval', $request->input('ai_tools', []));

        sort($oldAiIds);
        sort($newAiIds);

        $aiListChanged = ($oldAiIds !== $newAiIds);

        $validated = $request->validated();
        if ($aiListChanged) {
            $validated['status'] = 'Draft';
        }

        $project->update($validated);
        $project->aiTools()->sync($newAiIds);
        
        // Clean up matrix values for AI tools that were overridden/removed from the project
        MatrixValue::where('project_id', $project->id)
            ->whereNotIn('ai_id', $newAiIds)
            ->delete();

        $this->updateStatsCache();

        ActivityLog::create([
            'aktivitas' => "Memperbarui data proyek: '{$project->nama_proyek}'."
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Data Proyek berhasil diperbarui.' . ($aiListChanged ? ' Daftar AI berubah, hasil TOPSIS sebelumnya direset.' : ''));
    }

    public function destroy(Project $project): RedirectResponse
    {
        $projectName = $project->nama_proyek;
        $project->delete();
        $this->updateStatsCache();

        ActivityLog::create([
            'aktivitas' => "Menghapus proyek: '{$projectName}'."
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Data Proyek berhasil dihapus.');
    }

    public function calculateTopsis(Project $project, TopsisService $topsisService): RedirectResponse
    {
        try {
            // Run TOPSIS Manual Service Engine
            $topsisService->calculate($project);

            // Update Project Status to "Selesai"
            $project->update(['status' => 'Selesai']);

            // Update stats cache
            $this->updateStatsCache();

            // Record in activity log
            ActivityLog::create([
                'aktivitas' => "Administrator berhasil mengeksekusi perhitungan TOPSIS untuk proyek '{$project->nama_proyek}'."
            ]);

            return redirect()->route('projects.results', $project->id)
                ->with('success', 'Perhitungan TOPSIS berhasil diselesaikan. Status proyek diperbarui menjadi selesai.');

        } catch (\Exception $e) {
            // Record failure in activity log
            ActivityLog::create([
                'aktivitas' => "Gagal mengeksekusi perhitungan TOPSIS untuk proyek '{$project->nama_proyek}'. Error: {$e->getMessage()}"
            ]);

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    public function results(Project $project): View
    {
        $assessment = Assessment::where('project_id', $project->id)->orderBy('id', 'desc')->first();
        
        $results = collect();
        $bestAi = null;

        if ($assessment) {
            $results = TopsisResult::with('aiTool')
                ->where('assessment_id', $assessment->id)
                ->orderBy('ranking', 'asc')
                ->get();
            $bestAi = $results->first();
        }

        return view('admin.projects.results', compact('project', 'results', 'bestAi', 'assessment'));
    }

    public function calculationDetails(Project $project): View
    {
        $assessment = Assessment::where('project_id', $project->id)->orderBy('id', 'desc')->first();

        $logs = [];
        if ($assessment) {
            $logs = CalculationLog::where('assessment_id', $assessment->id)
                ->pluck('data_json', 'tahap')
                ->toArray();
        }

        $aiTools = $project->aiTools()->orderBy('id', 'asc')->get();
        $criteria = Criterion::orderBy('id', 'asc')->get();

        return view('admin.projects.calculation', compact('project', 'logs', 'aiTools', 'criteria'));
    }
}
