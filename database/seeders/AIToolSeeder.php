<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AIToolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ai_tools')->insertOrIgnore([
            [
                'id' => 1,
                'nama_ai' => 'ChatGPT',
                'developer' => 'OpenAI',
                'kategori' => 'Teks, Coding, Riset',
                'website' => 'https://chat.openai.com',
                'deskripsi' => 'Model bahasa besar generasi terbaru dari OpenAI. Unggul dalam penulisan, coding, brainstorming, dan analisis teks panjang dengan akurasi tinggi.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'nama_ai' => 'Gemini',
                'developer' => 'Google DeepMind',
                'kategori' => 'Teks, Multimodal, Riset',
                'website' => 'https://gemini.google.com',
                'deskripsi' => 'AI multimodal dari Google yang mendukung teks, gambar, dan kode. Terintegrasi erat dengan ekosistem Google Workspace.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'nama_ai' => 'Claude',
                'developer' => 'Anthropic',
                'kategori' => 'Teks, Analisis, Copywriting',
                'website' => 'https://claude.ai',
                'deskripsi' => 'Asisten AI dari Anthropic yang sangat unggul dalam analisis dokumen panjang, nuansa bahasa, dan keamanan konten.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'nama_ai' => 'Copilot',
                'developer' => 'Microsoft',
                'kategori' => 'Coding, Teks, Produktivitas',
                'website' => 'https://copilot.microsoft.com',
                'deskripsi' => 'Asisten AI dari Microsoft berbasis GPT-4 yang terintegrasi di Microsoft 365. Sangat andal untuk produktivitas, coding di VS Code, dan analisis data.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 5,
                'nama_ai' => 'Perplexity',
                'developer' => 'Perplexity AI',
                'kategori' => 'Riset, Pencarian',
                'website' => 'https://www.perplexity.ai',
                'deskripsi' => 'Mesin pencari bertenaga AI yang menyajikan jawaban akurat disertai kutipan sumber real-time. Ideal untuk riset cepat.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 6,
                'nama_ai' => 'DeepSeek',
                'developer' => 'DeepSeek',
                'kategori' => 'Coding, Riset, Teks',
                'website' => 'https://www.deepseek.com',
                'deskripsi' => 'Model AI open-source dari China dengan performa kompetitif di bidang coding dan analisis. Tersedia gratis dengan biaya operasional sangat rendah.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 7,
                'nama_ai' => 'Grok',
                'developer' => 'xAI',
                'kategori' => 'Riset, Social Media, Teks',
                'website' => 'https://grok.x.ai',
                'deskripsi' => 'AI asisten dari xAI (Elon Musk) yang memiliki akses real-time ke data platform X/Twitter. Ideal untuk analisis tren.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 8,
                'nama_ai' => 'Meta AI',
                'developer' => 'Meta',
                'kategori' => 'Teks, Social Media',
                'website' => 'https://www.meta.ai',
                'deskripsi' => 'Asisten AI dari Meta yang terintegrasi langsung di WhatsApp, Instagram, dan Facebook.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 9,
                'nama_ai' => 'Midjourney',
                'developer' => 'Midjourney Inc.',
                'kategori' => 'Image Generation, Desain Grafis',
                'website' => 'https://www.midjourney.com',
                'deskripsi' => 'Platform generative AI terdepan dalam menghasilkan gambar artistik berkualitas sangat tinggi. Diakses melalui Discord.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 10,
                'nama_ai' => 'Leonardo AI',
                'developer' => 'Leonardo.Ai',
                'kategori' => 'Image Generation, Desain Grafis',
                'website' => 'https://leonardo.ai',
                'deskripsi' => 'Platform AI image generation berbasis web dengan berbagai model dan kontrol kreatif yang detail.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 11,
                'nama_ai' => 'Canva AI',
                'developer' => 'Canva',
                'kategori' => 'Desain Grafis, Presentasi',
                'website' => 'https://www.canva.com',
                'deskripsi' => 'Fitur AI terintegrasi dalam platform desain Canva. Sangat mudah digunakan oleh non-desainer untuk membuat konten visual.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 12,
                'nama_ai' => 'Gamma',
                'developer' => 'Gamma App',
                'kategori' => 'Presentasi, Dokumen',
                'website' => 'https://gamma.app',
                'deskripsi' => 'AI pembuat slide presentasi, dokumen, dan landing page secara instan. Mengubah teks atau outline menjadi presentasi visual profesional.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 13,
                'nama_ai' => 'NotebookLM',
                'developer' => 'Google',
                'kategori' => 'Riset, Analisis Dokumen',
                'website' => 'https://notebooklm.google.com',
                'deskripsi' => 'Buku catatan virtual bertenaga AI dari Google untuk menganalisis, merangkum, dan menjawab pertanyaan berdasarkan dokumen.',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
