<?php

namespace App\Http\Controllers;

use App\Models\AITool;
use App\Models\Statistic;
use App\Models\ActivityLog;
use App\Http\Requests\StoreAIToolRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AIToolController extends Controller
{
    private function updateStatsCache(): void
    {
        Statistic::where('nama_statistik', 'total_ai_tools')
            ->update(['nilai' => AITool::count()]);
    }

    public function index(Request $request): View
    {
        $search = $request->input('search');

        $aiTools = AITool::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_ai', 'like', "%{$search}%")
                             ->orWhere('developer', 'like', "%{$search}%")
                             ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.ai.index', compact('aiTools', 'search'));
    }

    public function create(): View
    {
        return view('admin.ai.create');
    }

    public function store(StoreAIToolRequest $request): RedirectResponse
    {
        $aiTool = AITool::create($request->validated());
        $this->updateStatsCache();

        ActivityLog::create([
            'aktivitas' => "Menambahkan alternatif AI Tool baru: '{$aiTool->nama_ai}'."
        ]);

        return redirect()->route('ai-tools.index')
            ->with('success', 'Data AI Tool baru berhasil ditambahkan.');
    }

    public function show(AITool $aiTool): View
    {
        return view('admin.ai.show', compact('aiTool'));
    }

    public function edit(AITool $aiTool): View
    {
        return view('admin.ai.edit', compact('aiTool'));
    }

    public function update(StoreAIToolRequest $request, AITool $aiTool): RedirectResponse
    {
        $aiTool->update($request->validated());
        $this->updateStatsCache();

        ActivityLog::create([
            'aktivitas' => "Mengubah data AI Tool: '{$aiTool->nama_ai}'."
        ]);

        return redirect()->route('ai-tools.index')
            ->with('success', 'Data AI Tool berhasil diperbarui.');
    }

    public function destroy(AITool $aiTool): RedirectResponse
    {
        $aiName = $aiTool->nama_ai;
        $aiTool->delete();
        $this->updateStatsCache();

        ActivityLog::create([
            'aktivitas' => "Menghapus AI Tool: '{$aiName}'."
        ]);

        return redirect()->route('ai-tools.index')
            ->with('success', 'Data AI Tool berhasil dihapus.');
    }
}
