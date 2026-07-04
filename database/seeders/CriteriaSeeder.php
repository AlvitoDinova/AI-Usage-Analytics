<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('criteria')->insertOrIgnore([
            [
                'id' => 1,
                'kode' => 'K1',
                'nama_kriteria' => 'Akurasi',
                'tipe' => 'Benefit',
                'deskripsi' => 'Tingkat keakuratan dan kebenaran output yang dihasilkan AI.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'kode' => 'K2',
                'nama_kriteria' => 'Kemudahan Penggunaan',
                'tipe' => 'Benefit',
                'deskripsi' => 'Seberapa mudah dan intuitif antarmuka serta alur kerja AI dapat digunakan.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'kode' => 'K3',
                'nama_kriteria' => 'Harga',
                'tipe' => 'Cost',
                'deskripsi' => 'Biaya berlangganan atau penggunaan AI. Tipe Cost berarti harga lebih mahal dianggap buruk.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'kode' => 'K4',
                'nama_kriteria' => 'Kecepatan',
                'tipe' => 'Benefit',
                'deskripsi' => 'Kecepatan respons dan pemrosesan AI dalam menghasilkan output.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'kode' => 'K5',
                'nama_kriteria' => 'Bahasa Indonesia',
                'tipe' => 'Benefit',
                'deskripsi' => 'Kemampuan AI memahami dan menghasilkan konten dalam Bahasa Indonesia dengan kualitas yang baik.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'kode' => 'K6',
                'nama_kriteria' => 'Integrasi',
                'tipe' => 'Benefit',
                'deskripsi' => 'Kemampuan AI untuk berintegrasi dengan tools dan platform lain yang digunakan oleh tim.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'kode' => 'K7',
                'nama_kriteria' => 'Kemampuan Coding',
                'tipe' => 'Benefit',
                'deskripsi' => 'Kemampuan AI dalam membantu penulisan, debugging, dan penjelasan kode pemrograman.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'kode' => 'K8',
                'nama_kriteria' => 'Kemampuan Desain',
                'tipe' => 'Benefit',
                'deskripsi' => 'Kemampuan AI dalam menghasilkan atau mendukung pembuatan aset visual, gambar, dan elemen desain grafis.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 9,
                'kode' => 'K9',
                'nama_kriteria' => 'Kemampuan Copywriting',
                'tipe' => 'Benefit',
                'deskripsi' => 'Kemampuan AI dalam menghasilkan teks marketing, copywriting, caption, dan artikel berkualitas.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 10,
                'kode' => 'K10',
                'nama_kriteria' => 'Brainstorming',
                'tipe' => 'Benefit',
                'deskripsi' => 'Kemampuan AI dalam membantu proses ideasi, generasi konsep, dan eksplorasi ide kreatif.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
