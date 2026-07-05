<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use App\Models\AITool;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AIToolMappingController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $projectTypes = ProjectType::with('aiTools')
            ->when($search, function ($query, $search) {
                return $query->where('nama_proyek', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.ai-mappings.index', compact('projectTypes', 'search'));
    }

    public function edit(ProjectType $projectType): View
    {
        $aiTools = AITool::where('status', 'aktif')
            ->orderBy('nama_ai', 'asc')
            ->get();

        $mappedAiIds = $projectType->aiTools->pluck('id')->toArray();

        return view('admin.ai-mappings.edit', compact('projectType', 'aiTools', 'mappedAiIds'));
    }

    public function update(Request $request, ProjectType $projectType): RedirectResponse
    {
        $request->validate([
            'ai_tools' => 'nullable|array',
            'ai_tools.*' => 'exists:ai_tools,id',
        ], [
            'ai_tools.*.exists' => 'AI Tool yang dipilih tidak valid.',
        ]);

        $projectType->aiTools()->sync($request->input('ai_tools', []));

        ActivityLog::create([
            'aktivitas' => "Memperbarui pemetaan AI untuk jenis proyek: '{$projectType->nama_proyek}'."
        ]);

        return redirect()->route('ai-mappings.index')
            ->with('success', "Pemetaan AI untuk jenis proyek '{$projectType->nama_proyek}' berhasil diperbarui.");
    }
}
