<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\MatrixValue;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DecisionMatrixController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::orderBy('id', 'desc')->get();
        $selectedProjectId = $request->input('project_id');

        $selectedProject = null;
        $aiTools = collect();
        $criteria = collect();
        $matrixScores = collect();

        if ($selectedProjectId) {
            $selectedProject = Project::find($selectedProjectId);
            if ($selectedProject) {
                // Fetch active AI tools and active Criteria
                $aiTools = AITool::where('status', 'aktif')->orderBy('id', 'asc')->get();
                $criteria = Criterion::orderBy('id', 'asc')->get();
                
                // Fetch matrix values ISOLATED by project_id
                $matrixScores = MatrixValue::where('project_id', $selectedProjectId)->get()->groupBy('ai_id');
            }
        }

        return view('admin.matrix.index', compact('projects', 'selectedProjectId', 'selectedProject', 'aiTools', 'criteria', 'matrixScores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $projectId = $request->input('project_id');
        $scores = $request->input('scores', []); // Nested array: scores[ai_id][criteria_id] = score_value

        $project = Project::findOrFail($projectId);

        // Validation: verify that all inputs are filled and score scale is between 1 and 5
        foreach ($scores as $aiId => $criteriaScores) {
            foreach ($criteriaScores as $criteriaId => $score) {
                if (empty($score) || !in_array((int)$score, [1, 2, 3, 4, 5])) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Semua nilai sel matriks keputusan wajib diisi dengan skala 1-5.');
                }
            }
        }

        // Database transaction to save/update values safely ISOLATED by project_id
        DB::transaction(function () use ($scores, $project) {
            foreach ($scores as $aiId => $criteriaScores) {
                foreach ($criteriaScores as $criteriaId => $score) {
                    MatrixValue::updateOrCreate(
                        [
                            'project_id' => $project->id, 
                            'ai_id' => $aiId, 
                            'criteria_id' => $criteriaId
                        ],
                        ['nilai' => (int) $score]
                    );
                }
            }

            // Update status of project to "Dinilai"
            $project->update(['status' => 'Dinilai']);
        });

        return redirect()->route('matrix.index', ['project_id' => $project->id])
            ->with('success', "Matriks keputusan berhasil disimpan. Status proyek '{$project->nama_proyek}' diperbarui menjadi 'Dinilai'.");
    }
}
