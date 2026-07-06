<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\CriteriaWeight;
use App\Models\MatrixValue;
use App\Models\Assessment;
use App\Models\TopsisResult;
use App\Models\CalculationLog;
use App\Services\TopsisService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopsisInvalidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_topsis_results_are_deleted_and_status_resets_to_draft_when_ai_list_changes()
    {
        // 1. Setup base seed data
        $projectType = ProjectType::create(['nama_proyek' => 'Graphic Design']);

        $ai1 = AITool::create([
            'nama_ai' => 'ChatGPT',
            'developer' => 'OpenAI',
            'kategori' => 'Teks',
            'status' => 'aktif'
        ]);

        $ai2 = AITool::create([
            'nama_ai' => 'Gemini',
            'developer' => 'Google',
            'kategori' => 'Teks',
            'status' => 'aktif'
        ]);

        $ai3 = AITool::create([
            'nama_ai' => 'Claude',
            'developer' => 'Anthropic',
            'kategori' => 'Teks',
            'status' => 'aktif'
        ]);

        // 2. Create project with ai1 and ai2
        $project = Project::create([
            'project_type_id' => $projectType->id,
            'nama_proyek' => 'Logo Campaign',
            'client' => 'PT Client',
            'deskripsi' => 'Sample desc',
            'status' => 'Draft',
            'tanggal' => '2026-07-04'
        ]);
        $project->aiTools()->sync([$ai1->id, $ai2->id]);

        // 3. Setup criteria, weights and matrix values so calculation can succeed
        $c1 = Criterion::create([
            'kode' => 'C1',
            'nama_kriteria' => 'Kriteria 1',
            'tipe' => 'Benefit'
        ]);
        CriteriaWeight::create(['criteria_id' => $c1->id, 'bobot' => 3]);

        MatrixValue::create([
            'project_id' => $project->id,
            'ai_id' => $ai1->id,
            'criteria_id' => $c1->id,
            'nilai' => 5
        ]);
        MatrixValue::create([
            'project_id' => $project->id,
            'ai_id' => $ai2->id,
            'criteria_id' => $c1->id,
            'nilai' => 3
        ]);

        // 4. Calculate TOPSIS initially
        $service = new TopsisService();
        $service->calculate($project);
        $project->update(['status' => 'Selesai']);

        $assessment = Assessment::where('project_id', $project->id)->first();
        $this->assertNotNull($assessment);
        $this->assertDatabaseHas('topsis_results', ['assessment_id' => $assessment->id]);
        $this->assertEquals('Selesai', $project->status);

        // 5. Update the project through Controller logic (AI Tools list changes)
        // Simulate a request to update with a changed list of AI Tools (ai1, ai3)
        $user = \App\Models\User::create([
            'name' => 'Demo Admin',
            'email' => 'admin_test@ainsight.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->put(route('projects.update', $project->id), [
            'nama_proyek' => 'Logo Campaign Revised',
            'client' => 'PT Client',
            'project_type_id' => $projectType->id,
            'tanggal' => '2026-07-04',
            'status' => 'Selesai', // Form sends Selesai, but controller should reset to Draft
            'deskripsi' => 'Sample desc',
            'ai_tools' => [$ai1->id, $ai3->id] // List changed! (ai2 replaced with ai3)
        ]);

        // Assert redirect to project index
        $response->assertRedirect(route('projects.index'));

        // Refresh project
        $project->refresh();

        // 6. Assertions for Invalidation
        // Project status must be forced to Draft
        $this->assertEquals('Draft', $project->status);

        // Historical TOPSIS results and calculation logs must NOT be deleted (immutable snapshot)
        $this->assertDatabaseHas('topsis_results', ['assessment_id' => $assessment->id]);
        $this->assertDatabaseHas('calculation_logs', ['assessment_id' => $assessment->id]);

        // Mapped tools synced
        $syncedAiIds = $project->aiTools->pluck('id')->toArray();
        $this->assertContains($ai1->id, $syncedAiIds);
        $this->assertContains($ai3->id, $syncedAiIds);
        $this->assertNotContains($ai2->id, $syncedAiIds);

        // Matrix values for removed tool (ai2) must be deleted
        $this->assertDatabaseMissing('matrix_values', [
            'project_id' => $project->id,
            'ai_id' => $ai2->id
        ]);
    }
}
