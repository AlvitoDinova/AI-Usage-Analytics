<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Statistic;
use App\Http\Requests\StoreCriterionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CriterionController extends Controller
{
    private function updateStatsCache(): void
    {
        Statistic::where('nama_statistik', 'total_kriteria')
            ->update(['nilai' => Criterion::count()]);
    }

    public function index(Request $request): View
    {
        $search = $request->input('search');

        $criteria = Criterion::query()
            ->when($search, function ($query, $search) {
                return $query->where('kode', 'like', "%{$search}%")
                             ->orWhere('nama_kriteria', 'like', "%{$search}%")
                             ->orWhere('tipe', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.criteria.index', compact('criteria', 'search'));
    }

    public function create(): View
    {
        return view('admin.criteria.create');
    }

    public function store(StoreCriterionRequest $request): RedirectResponse
    {
        Criterion::create($request->validated());
        $this->updateStatsCache();

        return redirect()->route('criteria.index')
            ->with('success', 'Data Kriteria baru berhasil ditambahkan.');
    }

    public function edit(Criterion $criterion): View
    {
        return view('admin.criteria.edit', compact('criterion'));
    }

    public function update(StoreCriterionRequest $request, Criterion $criterion): RedirectResponse
    {
        $criterion->update($request->validated());
        $this->updateStatsCache();

        return redirect()->route('criteria.index')
            ->with('success', 'Data Kriteria berhasil diperbarui.');
    }

    public function destroy(Criterion $criterion): RedirectResponse
    {
        $criterion->delete();
        $this->updateStatsCache();

        return redirect()->route('criteria.index')
            ->with('success', 'Data Kriteria berhasil dihapus.');
    }
}
