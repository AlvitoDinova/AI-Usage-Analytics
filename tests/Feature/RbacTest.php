<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\AITool;
use App\Models\Criterion;
use App\Models\Assessment;
use App\Models\TopsisResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic stats cache structure so Dashboard and other actions do not crash
        \Illuminate\Support\Facades\DB::table('statistics')->insert([
            ['id' => 1, 'nama_statistik' => 'total_ai_tools', 'nilai' => 0],
            ['id' => 2, 'nama_statistik' => 'total_kriteria', 'nilai' => 0],
            ['id' => 3, 'nama_statistik' => 'total_penilaian', 'nilai' => 0],
            ['id' => 4, 'nama_statistik' => 'total_proyek', 'nilai' => 0],
            ['id' => 5, 'nama_statistik' => 'ai_terpilih_terbanyak', 'nilai' => 0],
        ]);
    }

    public function test_unauthenticated_users_are_redirected_to_login()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_users_can_login_with_correct_credentials()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@ainsight.test',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'status' => 'active',
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'test@ainsight.test',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_users_cannot_login_with_incorrect_credentials()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@ainsight.test',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'status' => 'active',
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'test@ainsight.test',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('error', 'Email atau Password yang Anda masukkan tidak sesuai.');
        $this->assertGuest();
    }

    public function test_inactive_users_cannot_login()
    {
        User::create([
            'name' => 'Test Inactive',
            'email' => 'inactive@ainsight.test',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'status' => 'inactive',
        ]);

        $response = $this->post(route('login.post'), [
            'email' => 'inactive@ainsight.test',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_admin_can_access_user_management_and_master_data()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@ainsight.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get(route('users.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get(route('ai-tools.index'));
        $response->assertStatus(200);
    }

    public function test_manager_cannot_access_user_management_or_master_data()
    {
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@ainsight.test',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'status' => 'active',
        ]);

        // Manager cannot access User Management CRUD
        $response = $this->actingAs($manager)->get(route('users.index'));
        $response->assertStatus(403);

        // Manager cannot access AI Tools CRUD
        $response = $this->actingAs($manager)->get(route('ai-tools.index'));
        $response->assertStatus(403);

        // Manager can access Statistics page
        $response = $this->actingAs($manager)->get(route('statistics.index'));
        $response->assertStatus(200);
    }

    public function test_employee_can_only_see_their_own_projects_and_history()
    {
        $emp1 = User::create([
            'name' => 'Employee 1',
            'email' => 'emp1@ainsight.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'status' => 'active',
        ]);

        $emp2 = User::create([
            'name' => 'Employee 2',
            'email' => 'emp2@ainsight.test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'status' => 'active',
        ]);

        $projectType = ProjectType::create(['nama_proyek' => 'Logo Design']);

        $project1 = Project::create([
            'nama_proyek' => 'Emp1 Project',
            'client' => 'Client A',
            'project_type_id' => $projectType->id,
            'owner_id' => $emp1->id,
            'status' => 'Draft',
            'tanggal' => '2026-07-05',
        ]);

        $project2 = Project::create([
            'nama_proyek' => 'Emp2 Project',
            'client' => 'Client B',
            'project_type_id' => $projectType->id,
            'owner_id' => $emp2->id,
            'status' => 'Draft',
            'tanggal' => '2026-07-05',
        ]);

        // Emp1 acting as user
        // 1. Can see project 1 on index
        $response = $this->actingAs($emp1)->get(route('projects.index'));
        $response->assertStatus(200);
        $response->assertSee('Emp1 Project');
        $response->assertDontSee('Emp2 Project');

        // 2. Can access project 1 show page
        $response = $this->actingAs($emp1)->get(route('projects.show', $project1->id));
        $response->assertStatus(200);

        // 3. Cannot access project 2 show page (throws 403)
        $response = $this->actingAs($emp1)->get(route('projects.show', $project2->id));
        $response->assertStatus(403);
    }
}
