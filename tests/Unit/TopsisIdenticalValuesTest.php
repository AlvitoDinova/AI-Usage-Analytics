<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\CriteriaWeight;
use App\Models\MatrixValue;
use App\Services\TopsisService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopsisIdenticalValuesTest extends TestCase
{
    use RefreshDatabase;

    public function test_topsis_calculation_with_identical_alternatives_gracefully_falls_back_to_0_5()
    {
        // 1. Create a Project Type
        $projectType = ProjectType::create(['nama_proyek' => 'Graphic Design']);

        // 2. Create 2 AI Tools
        $ai1 = AITool::create([
            'nama_ai' => 'AI Tool A',
            'developer' => 'Developer A',
            'kategori' => 'Graphic Design',
            'website' => 'https://ai-a.com',
            'deskripsi' => 'AI tool A description',
            'status' => 'aktif'
        ]);

        $ai2 = AITool::create([
            'nama_ai' => 'AI Tool B',
            'developer' => 'Developer B',
            'kategori' => 'Graphic Design',
            'website' => 'https://ai-b.com',
            'deskripsi' => 'AI tool B description',
            'status' => 'aktif'
        ]);

        // 3. Create a Project and associate both AI Tools
        $project = Project::create([
            'project_type_id' => $projectType->id,
            'nama_proyek' => 'Test Project',
            'client' => 'Test Client',
            'deskripsi' => 'Test description',
            'status' => 'Draft',
            'tanggal' => '2026-07-04'
        ]);
        $project->aiTools()->sync([$ai1->id, $ai2->id]);

        // 4. Create 3 Criteria with Benefit and Cost types
        $c1 = Criterion::create([
            'kode' => 'C1',
            'nama_kriteria' => 'Kriteria 1',
            'tipe' => 'Benefit',
            'deskripsi' => 'Kriteria 1 deskripsi'
        ]);

        $c2 = Criterion::create([
            'kode' => 'C2',
            'nama_kriteria' => 'Kriteria 2',
            'tipe' => 'Cost',
            'deskripsi' => 'Kriteria 2 deskripsi'
        ]);

        // 5. Create weights
        CriteriaWeight::create(['criteria_id' => $c1->id, 'bobot' => 4]);
        CriteriaWeight::create(['criteria_id' => $c2->id, 'bobot' => 3]);

        // 6. Seed identical values for both AI tools
        // Both AI tools score exactly 4 on C1 and exactly 2 on C2
        MatrixValue::create([
            'project_id' => $project->id,
            'ai_id' => $ai1->id,
            'criteria_id' => $c1->id,
            'nilai' => 4
        ]);
        MatrixValue::create([
            'project_id' => $project->id,
            'ai_id' => $ai1->id,
            'criteria_id' => $c2->id,
            'nilai' => 2
        ]);

        MatrixValue::create([
            'project_id' => $project->id,
            'ai_id' => $ai2->id,
            'criteria_id' => $c1->id,
            'nilai' => 4
        ]);
        MatrixValue::create([
            'project_id' => $project->id,
            'ai_id' => $ai2->id,
            'criteria_id' => $c2->id,
            'nilai' => 2
        ]);

        // 7. Execute TOPSIS Service
        $service = new TopsisService();
        $results = $service->calculate($project);

        // 8. Assertions
        $this->assertCount(2, $results);
        
        // Both preference values should be exactly 0.5 because the division-by-zero is handled.
        $this->assertEquals(0.5, $results[0]['preference_value']);
        $this->assertEquals(0.5, $results[1]['preference_value']);

        // Assert database values are successfully persisted
        $this->assertDatabaseHas('topsis_results', [
            'ai_id' => $ai1->id,
            'nilai_preferensi' => 0.5
        ]);
        $this->assertDatabaseHas('topsis_results', [
            'ai_id' => $ai2->id,
            'nilai_preferensi' => 0.5
        ]);
    }
}
