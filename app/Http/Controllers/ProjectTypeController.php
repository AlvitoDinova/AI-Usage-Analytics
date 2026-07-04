<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use App\Http\Requests\StoreProjectTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectTypeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $projectTypes = ProjectType::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_proyek', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.project-types.index', compact('projectTypes', 'search'));
    }

    public function create(): View
    {
        return view('admin.project-types.create');
    }

    public function store(StoreProjectTypeRequest $request): RedirectResponse
    {
        ProjectType::create($request->validated());

        return redirect()->route('project-types.index')
            ->with('success', 'Jenis proyek baru berhasil ditambahkan.');
    }

    public function edit(ProjectType $projectType): View
    {
        return view('admin.project-types.edit', compact('projectType'));
    }

    public function update(StoreProjectTypeRequest $request, ProjectType $projectType): RedirectResponse
    {
        $projectType->update($request->validated());

        return redirect()->route('project-types.index')
            ->with('success', 'Jenis proyek berhasil diperbarui.');
    }

    public function destroy(ProjectType $projectType): RedirectResponse
    {
        // Protect constraints in case projects are referencing this type
        try {
            $projectType->delete();
            return redirect()->route('project-types.index')
                ->with('success', 'Jenis proyek berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('project-types.index')
                ->with('error', 'Gagal menghapus. Data jenis proyek ini sedang digunakan oleh transaksi proyek.');
        }
    }
}
