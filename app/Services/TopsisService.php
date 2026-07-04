<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\CriteriaWeight;
use App\Models\MatrixValue;
use App\Models\TopsisResult;
use App\Models\CalculationLog;
use Illuminate\Support\Facades\DB;

class TopsisService
{
    public function calculate(Project $project): array
    {
        // 1. Initial Assessment check
        $assessment = Assessment::firstOrCreate(
            ['project_id' => $project->id],
            ['tanggal_penilaian' => now()]
        );

        $criteria = Criterion::orderBy('id', 'asc')->get();
        $aiTools = AITool::where('status', 'aktif')->orderBy('id', 'asc')->get();

        if ($aiTools->isEmpty() || $criteria->isEmpty()) {
            throw new \Exception("Kalkulasi gagal. Data AI Tools aktif atau Kriteria tidak boleh kosong.");
        }

        // Copy default weights to assessment_details if not present
        foreach ($criteria as $c) {
            $hasDetail = AssessmentDetail::where([
                'assessment_id' => $assessment->id,
                'criteria_id' => $c->id
            ])->exists();

            if (!$hasDetail) {
                $defaultWeight = CriteriaWeight::where('criteria_id', $c->id)->value('bobot') ?? 3;
                AssessmentDetail::create([
                    'assessment_id' => $assessment->id,
                    'criteria_id' => $c->id,
                    'bobot' => $defaultWeight
                ]);
            }
        }

        // Fetch customized weights for this assessment
        $weights = AssessmentDetail::where('assessment_id', $assessment->id)
            ->pluck('bobot', 'criteria_id')
            ->toArray();

        // 2. Fetch Project Decision Matrix X
        // Decision Matrix values X[ai_id][criteria_id]
        $x = [];
        foreach ($aiTools as $ai) {
            foreach ($criteria as $c) {
                $val = MatrixValue::where([
                    'project_id' => $project->id,
                    'ai_id' => $ai->id,
                    'criteria_id' => $c->id
                ])->value('nilai');

                if ($val === null) {
                    throw new \Exception("Kalkulasi gagal. Nilai matriks keputusan untuk AI {$ai->nama_ai} pada kriteria {$c->kode} belum diisi.");
                }
                $x[$ai->id][$c->id] = (int) $val;
            }
        }

        // 3. Normalization (R)
        // Calculate divider sum of squares for each criterion: Divider[c_id] = sqrt( sum(x_ij^2) )
        $divider = [];
        foreach ($criteria as $c) {
            $sumSq = 0;
            foreach ($aiTools as $ai) {
                $sumSq += pow($x[$ai->id][$c->id], 2);
            }
            $divider[$c->id] = sqrt($sumSq);
        }

        // Form Normalized Matrix R[ai_id][criteria_id]
        $r = [];
        foreach ($aiTools as $ai) {
            foreach ($criteria as $c) {
                $div = $divider[$c->id];
                $r[$ai->id][$c->id] = ($div == 0) ? 0.0 : ($x[$ai->id][$c->id] / $div);
            }
        }

        // 4. Weight Normalization & Weighted Matrix (Y)
        // Calculate sum of weights for normalizations
        $totalWeight = array_sum($weights);
        if ($totalWeight == 0) $totalWeight = 1;

        // Form Weighted Matrix Y[ai_id][criteria_id] = normalized_weight * R_ij
        $y = [];
        foreach ($aiTools as $ai) {
            foreach ($criteria as $c) {
                $normWeight = $weights[$c->id] / $totalWeight;
                $y[$ai->id][$c->id] = $normWeight * $r[$ai->id][$c->id];
            }
        }

        // 5. Positive (A+) and Negative (A-) Ideal Solutions
        // Coordinate arrays A_plus[c_id] and A_minus[c_id]
        $aPlus = [];
        $aMinus = [];
        foreach ($criteria as $c) {
            $cValues = [];
            foreach ($aiTools as $ai) {
                $cValues[] = $y[$ai->id][$c->id];
            }

            if ($c->tipe === 'Benefit') {
                $aPlus[$c->id] = max($cValues);
                $aMinus[$c->id] = min($cValues);
            } else { // Cost
                $aPlus[$c->id] = min($cValues);
                $aMinus[$c->id] = max($cValues);
            }
        }

        // 6. Separation Measures (D+ and D-)
        $dPlus = [];
        $dMinus = [];
        foreach ($aiTools as $ai) {
            $sumDPlus = 0;
            $sumDMinus = 0;
            foreach ($criteria as $c) {
                $sumDPlus += pow($y[$ai->id][$c->id] - $aPlus[$c->id], 2);
                $sumDMinus += pow($y[$ai->id][$c->id] - $aMinus[$c->id], 2);
            }
            $dPlus[$ai->id] = sqrt($sumDPlus);
            $dMinus[$ai->id] = sqrt($sumDMinus);
        }

        // 7. Preference Value (Ci*)
        $preferences = [];
        foreach ($aiTools as $ai) {
            $dividerCi = $dPlus[$ai->id] + $dMinus[$ai->id];
            $preferences[$ai->id] = ($dividerCi == 0) ? 0.0 : ($dMinus[$ai->id] / $dividerCi);
        }

        // 8. Sorting and Ranking
        arsort($preferences);
        $rankings = [];
        $rank = 1;
        foreach ($preferences as $aiId => $prefValue) {
            $rankings[] = [
                'ai_id' => $aiId,
                'preference_value' => $prefValue,
                'ranking' => $rank++
            ];
        }

        // 9. Save final ranks & steps under Transaction
        DB::transaction(function () use ($assessment, $rankings, $x, $r, $y, $aPlus, $aMinus, $dPlus, $dMinus, $preferences) {
            // Clear old results
            TopsisResult::where('assessment_id', $assessment->id)->delete();
            CalculationLog::where('assessment_id', $assessment->id)->delete();

            // Insert new rankings
            foreach ($rankings as $row) {
                TopsisResult::create([
                    'assessment_id' => $assessment->id,
                    'ai_id' => $row['ai_id'],
                    'nilai_preferensi' => $row['preference_value'],
                    'ranking' => $row['ranking']
                ]);
            }

            // Save calculation logs of each step
            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Matriks Keputusan',
                'data_json' => $x
            ]);

            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Normalisasi',
                'data_json' => $r
            ]);

            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Matriks Terbobot',
                'data_json' => $y
            ]);

            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Solusi Ideal Positif',
                'data_json' => $aPlus
            ]);

            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Solusi Ideal Negatif',
                'data_json' => $aMinus
            ]);

            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Jarak Positif',
                'data_json' => $dPlus
            ]);

            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Jarak Negatif',
                'data_json' => $dMinus
            ]);

            CalculationLog::create([
                'assessment_id' => $assessment->id,
                'tahap' => 'Nilai Preferensi',
                'data_json' => $preferences
            ]);
        });

        return $rankings;
    }
}
