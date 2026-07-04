<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProjectTypeSeeder::class,
            AIToolSeeder::class,
            CriteriaSeeder::class,
            CriteriaWeightSeeder::class,
        ]);

        // Seed 2 default projects so that MatrixValueSeeder has valid FK project targets
        DB::table('projects')->insertOrIgnore([
            [
                'id' => 1,
                'project_type_id' => 2, // Graphic Design
                'nama_proyek' => 'Campaign Q3 Notch Creative',
                'client' => 'PT Notch Digital',
                'deskripsi' => 'Desain grafis media kampanye Q3.',
                'status' => 'Draft',
                'tanggal' => '2026-07-02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'project_type_id' => 1, // Copywriting
                'nama_proyek' => 'Branding Notch Agency',
                'client' => 'Notch HQ',
                'deskripsi' => 'Riset copywriting untuk branding agensi.',
                'status' => 'Draft',
                'tanggal' => '2026-07-02',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $this->call([
            MatrixValueSeeder::class,
        ]);

        // Seed initial statistics cache values
        DB::table('statistics')->insertOrIgnore([
            ['id' => 1, 'nama_statistik' => 'total_ai_tools', 'nilai' => 13],
            ['id' => 2, 'nama_statistik' => 'total_kriteria', 'nilai' => 10],
            ['id' => 3, 'nama_statistik' => 'total_penilaian', 'nilai' => 0],
            ['id' => 4, 'nama_statistik' => 'total_proyek', 'nilai' => 0],
            ['id' => 5, 'nama_statistik' => 'ai_terpilih_terbanyak', 'nilai' => 0],
        ]);
    }
}
