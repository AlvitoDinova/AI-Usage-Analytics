<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('project_types')->insertOrIgnore([
            ['id' => 1, 'nama_proyek' => 'Copywriting'],
            ['id' => 2, 'nama_proyek' => 'Graphic Design'],
            ['id' => 3, 'nama_proyek' => 'Branding'],
            ['id' => 4, 'nama_proyek' => 'Motion Graphic'],
            ['id' => 5, 'nama_proyek' => 'Video Editing'],
            ['id' => 6, 'nama_proyek' => 'UI/UX'],
            ['id' => 7, 'nama_proyek' => 'Presentation'],
            ['id' => 8, 'nama_proyek' => 'Research'],
            ['id' => 9, 'nama_proyek' => 'Coding'],
            ['id' => 10, 'nama_proyek' => 'Social Media Content']
        ]);
    }
}
