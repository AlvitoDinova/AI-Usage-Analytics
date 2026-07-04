<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\CriteriaWeight;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use App\Http\Requests\StoreCriterionWeightRequest;

class CriterionWeightController extends Controller
{
    public function index(): View
    {
        // Fetch all criteria eager-loaded with their weights
        $criteria = Criterion::with('defaultWeight')->orderBy('id', 'asc')->get();
        $totalWeight = $criteria->sum(function ($c) {
            return $c->defaultWeight ? $c->defaultWeight->bobot : 0;
        });

        return view('admin.weights.index', compact('criteria', 'totalWeight'));
    }

    public function store(StoreCriterionWeightRequest $request): RedirectResponse
    {
        $weightsInput = $request->input('weights', []); // array of criteria_id => weight_value
        
        // Sum weights to validate 100% total
        $sum = array_sum($weightsInput);

        if ($sum !== 100) {
            return redirect()->back()
                ->withInput()
                ->with('warning', "Gagal memperbarui. Total jumlah bobot harus tepat 100%. Jumlah bobot saat ini: {$sum}%.");
        }

        // Use Database Transactions to update safely
        DB::transaction(function () use ($weightsInput) {
            foreach ($weightsInput as $criteriaId => $bobot) {
                CriteriaWeight::updateOrCreate(
                    ['criteria_id' => $criteriaId],
                    ['bobot' => (int) $bobot]
                );
            }
        });

        return redirect()->route('criterion-weights.index')
            ->with('success', 'Bobot kriteria berhasil diperbarui.');
    }
}
