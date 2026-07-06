<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        // Seed basic stats cache structure
        \Illuminate\Support\Facades\DB::table('statistics')->insertOrIgnore([
            ['id' => 1, 'nama_statistik' => 'total_ai_tools', 'nilai' => 0],
            ['id' => 2, 'nama_statistik' => 'total_kriteria', 'nilai' => 0],
            ['id' => 3, 'nama_statistik' => 'total_penilaian', 'nilai' => 0],
            ['id' => 4, 'nama_statistik' => 'total_proyek', 'nilai' => 0],
            ['id' => 5, 'nama_statistik' => 'ai_terpilih_terbanyak', 'nilai' => 0],
        ]);

        $user = User::create([
            'name' => 'Demo Admin',
            'email' => 'admin@ainsight.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active'
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
