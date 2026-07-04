<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatrixValueSeeder extends Seeder
{
    public function run(): void
    {
        $matrixProject1 = [
            // AI_ID => [K1, K2, K3, K4, K5, K6, K7, K8, K9, K10]
            1 => [5, 5, 3, 4, 4, 5, 5, 3, 5, 5], // ChatGPT
            2 => [5, 5, 2, 4, 5, 5, 4, 3, 4, 5], // Gemini
            3 => [5, 4, 3, 4, 3, 4, 5, 2, 5, 5], // Claude
            4 => [4, 5, 2, 4, 4, 5, 5, 2, 4, 4], // Copilot
            5 => [4, 4, 2, 5, 3, 3, 3, 1, 3, 4], // Perplexity
            6 => [5, 4, 1, 3, 3, 3, 5, 2, 4, 4], // DeepSeek
            7 => [4, 4, 2, 4, 3, 3, 4, 2, 4, 4], // Grok
            8 => [3, 5, 1, 4, 4, 4, 3, 2, 4, 4], // Meta AI
            9 => [3, 3, 4, 3, 2, 2, 1, 5, 2, 3], // Midjourney
            10 => [3, 4, 3, 3, 2, 3, 1, 5, 2, 3], // Leonardo AI
            11 => [3, 5, 3, 4, 4, 5, 1, 5, 4, 3], // Canva AI
            12 => [3, 5, 2, 4, 3, 4, 1, 4, 4, 4], // Gamma
            13 => [4, 4, 1, 3, 3, 3, 2, 1, 3, 5], // NotebookLM
        ];

        // Seed Project 1 scores
        $inserts = [];
        $id = 1;
        foreach ($matrixProject1 as $aiId => $scores) {
            foreach ($scores as $index => $score) {
                $criteriaId = $index + 1;
                $inserts[] = [
                    'id' => $id++,
                    'project_id' => 1, // Campaign Q3 Notch Creative
                    'ai_id' => $aiId,
                    'criteria_id' => $criteriaId,
                    'nilai' => $score
                ];
            }
        }

        // Seed Project 2 scores with slightly different scores to test database isolation
        foreach ($matrixProject1 as $aiId => $scores) {
            foreach ($scores as $index => $score) {
                $criteriaId = $index + 1;
                $val = ($score === 5) ? 4 : (($score === 3) ? 4 : $score); // alter some scores
                $inserts[] = [
                    'id' => $id++,
                    'project_id' => 2, // Branding Notch Agency
                    'ai_id' => $aiId,
                    'criteria_id' => $criteriaId,
                    'nilai' => $val
                ];
            }
        }

        DB::table('matrix_values')->insertOrIgnore($inserts);
    }
}
