<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriteriaWeightSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('criteria_weights')->insertOrIgnore([
            ['id' => 1,  'criteria_id' => 1,  'bobot' => 5], // K1 Akurasi
            ['id' => 2,  'criteria_id' => 2,  'bobot' => 4], // K2 Kemudahan
            ['id' => 3,  'criteria_id' => 3,  'bobot' => 4], // K3 Harga
            ['id' => 4,  'criteria_id' => 4,  'bobot' => 3], // K4 Kecepatan
            ['id' => 5,  'criteria_id' => 5,  'bobot' => 3], // K5 B.Indo
            ['id' => 6,  'criteria_id' => 6,  'bobot' => 3], // K6 Integrasi
            ['id' => 7,  'criteria_id' => 7,  'bobot' => 4], // K7 Coding
            ['id' => 8,  'criteria_id' => 8,  'bobot' => 4], // K8 Desain
            ['id' => 9,  'criteria_id' => 9,  'bobot' => 5], // K9 Copywriting
            ['id' => 10, 'criteria_id' => 10, 'bobot' => 4]  // K10 Brainstorming
        ]);
    }
}
