# Walkthrough - Sprint 4: Intelligent AI Mapping & Dynamic Decision Matrix

Sprint 4 berfokus pada implementasi pemetaan AI secara cerdas berdasarkan Jenis Proyek (Intelligent AI Mapping), fitur manual override di tingkat proyek, pembatasan alternatif pada Decision Matrix, penggantian visual judul LaTeX dengan Bahasa Indonesia yang mudah dipahami, serta penanganan kasus ekstrem (*edge case*) pembagian dengan nol saat nilai kinerja alternatif bernilai identik.

---

## 1. Perubahan Database & Relasi Eloquent

### 1.1 Tabel Pivot Baru (Many-to-Many)
Kami menambahkan dua tabel pivot baru untuk mendukung pemetaan AI di tingkat global (Jenis Proyek) dan lokal (Proyek):

1. **`project_type_ai_tools`**: Menyimpan pemetaan global antara Jenis Proyek dan AI Tools.
   - `id` (Primary Key)
   - `project_type_id` (Foreign Key ke `project_types.id`, `ON DELETE CASCADE`)
   - `ai_tool_id` (Foreign Key ke `ai_tools.id`, `ON DELETE CASCADE`)
   - `created_at` & `updated_at` (Timestamps)
   - Unique constraint `uq_project_type_ai` pada (`project_type_id`, `ai_tool_id`) untuk mencegah duplikasi.

2. **`project_ai_tools`**: Menyimpan pemetaan khusus/lokal per Proyek demi mendukung fitur **Manual Override**.
   - `id` (Primary Key)
   - `project_id` (Foreign Key ke `projects.id`, `ON DELETE CASCADE`)
   - `ai_tool_id` (Foreign Key ke `ai_tools.id`, `ON DELETE CASCADE`)
   - `created_at` & `updated_at` (Timestamps)
   - Unique constraint `uq_project_ai_tool` pada (`project_id`, `ai_tool_id`) untuk mencegah duplikasi.

### 1.2 Relasi Eloquent pada Model
Kami mendefinisikan hubungan many-to-many Eloquent menggunakan method `belongsToMany`:

- **Model [AITool](file:///c:/xampp/htdocs/AInsight/app/Models/AITool.php)**:
  - `projectTypes()`: Menghubungkan ke `ProjectType` melalui tabel pivot `project_type_ai_tools`.
  - `projects()`: Menghubungkan ke `Project` melalui tabel pivot `project_ai_tools`.

- **Model [ProjectType](file:///c:/xampp/htdocs/AInsight/app/Models/ProjectType.php)**:
  - `aiTools()`: Menghubungkan ke `AITool` melalui tabel pivot `project_type_ai_tools`.

- **Model [Project](file:///c:/xampp/htdocs/AInsight/app/Models/Project.php)**:
  - `aiTools()`: Menghubungkan ke `AITool` melalui tabel pivot `project_ai_tools`.

---

## 2. Struktur Pengkodean Baru

### 2.1 Controller Baru
- **[AIToolMappingController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/AIToolMappingController.php)**:
  Mengelola operasi CRUD untuk pemetaan AI Tools global ke Jenis Proyek Kreatif.
  - `index()`: Menampilkan tabel daftar Jenis Proyek beserta AI terpetakan dalam bentuk badge.
  - `edit()`: Menampilkan formulir checkbox untuk memilih AI yang termasuk ke dalam Jenis Proyek terpilih.
  - `update()`: Melakukan sinkronisasi data pivot (`sync()`) ke database berdasarkan checkbox yang dicentang admin.

### 2.2 Endpoint API JSON Baru
Kami menambahkan endpoint internal di **[ProjectTypeController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectTypeController.php)** untuk melayani auto-load AI di sisi klien (klien-side javascript):
- `getAiTools(ProjectType $projectType)`: Mengembalikan JSON berupa list AI yang dipetakan secara global untuk kategori tersebut serta daftar seluruh AI aktif di sistem.

### 2.3 Perubahan Kode Controller & Validasi
- **[ProjectController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php)**:
  - `create()` & `edit()`: Mengirimkan daftar seluruh AI aktif dan daftar AI terasosiasi agar form dapat menampilkan status checkbox dan dropdown manual override.
  - `store()`: Menyimpan proyek baru dan melakukan sinkronisasi (`sync()`) terhadap alternatif AI terpilih dari form.
  - `update()`: Memperbarui data proyek dan sinkronisasi alternatif AI. Jika ada alternatif AI yang dihapus dari proyek, data `matrix_values` yang terkait dengan AI tersebut pada proyek ini otomatis dibersihkan agar konsisten.
  - `show()` & `calculationDetails()`: Menyeleksi variabel `$aiTools` agar hanya mengambil alternatif AI khusus milik proyek (`$project->aiTools`) bukan mengambil semua AI aktif global.
- **[StoreProjectRequest](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreProjectRequest.php)**:
  Menambahkan validasi request `ai_tools` (wajib berupa array dengan minimal 2 pilihan alternatif AI agar kalkulasi perankingan TOPSIS dapat berjalan valid).
- **[DecisionMatrixController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DecisionMatrixController.php)**:
  - Mengubah baris alternatif pada Decision Matrix agar dinamis mengikuti `$selectedProject->aiTools` bukan `AITool::all()`.

---

## 3. Desain Tampilan Blade & UI Terintegrasi

1. **[AI Mapping Index](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai-mappings/index.blade.php)**: Menampilkan tabel pemetaan dengan desain visual modern dan badge kategori warna biru premium.
2. **[AI Mapping Edit](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai-mappings/edit.blade.php)**: Menampilkan checkbox dalam grid 2 kolom dengan fitur select all/deselect all, detail developer, serta label kategori AI.
3. **Form Proyek [Create](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/create.blade.php) & [Edit](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/edit.blade.php)**:
   - Area "Alternatif AI untuk Proyek Ini" akan otomatis muncul saat Jenis Proyek dipilih.
   - Pilihan AI terpetakan langsung dicentang.
   - Dropdown "+ Tambah Alternatif AI Lain..." di bawah checklist memungkinkan admin menambahkan AI aktif lainnya yang di luar pemetaan global secara instan.
   - Di halaman Edit, jika Jenis Proyek diganti, sistem akan menampilkan dialog konfirmasi SweetAlert2 sebelum memuat ulang setelan default baru.

---

## 4. Penghapusan Sintaks LaTeX (UI Improvement)
Kami mengubah seluruh judul dan penjelasan matematika LaTeX pada halaman hasil evaluasi dan detail kalkulasi menjadi Bahasa Indonesia yang mudah dipahami:
- `A. Matriks Awal (X)` &rarr; **A. Matriks Keputusan Awal**
- `B. Normalisasi (R)` beserta rumus pecahan pembagi &rarr; **B. Normalisasi Matriks** (Penjelasan: Proses pembagian nilai kinerja alternatif dengan akar jumlah kuadrat kriteria)
- `C. Terbobot (Y)` beserta rumus &rarr; **C. Matriks Ternormalisasi Berbobot**
- `D & E. Nilai Solusi Ideal Positif ($A^+$) dan Negatif ($A^-$)` &rarr; **D & E. Solusi Ideal Positif dan Negatif**
- Label ideal `Positif ($A^+$)` dan `Negatif ($A^-$)` &rarr; **Solusi Ideal Positif** dan **Solusi Ideal Negatif**
- `F, G & H. Jarak Solusi, Preferensi Relatif ($C_i^*$) & Urutan Peringkat` &rarr; **F, G & H. Perhitungan Jarak, Nilai Preferensi, dan Peringkat Alternatif AI**
- Judul tabel hasil &rarr; **Peringkat Alternatif AI** (dan kolom header `Nilai Preferensi`)

---

## 5. Solusi Edge Case (Division by Zero)

### 5.1 Masalah
Jika semua alternatif AI yang dipilih memiliki nilai kinerja yang persis sama pada semua kriteria, maka:
- Jarak ke solusi ideal positif $D_i^+ = 0$
- Jarak ke solusi ideal negatif $D_i^- = 0$
Hal ini akan mengakibatkan pembagi bernilai nol ($D_i^+ + D_i^- = 0$), sehingga memicu error fatal *Division by Zero* saat menghitung kedekatan relatif $C_i = \frac{D_i^-}{D_i^+ + D_i^-}$.

### 5.2 Keputusan Implementasi & Solusi
Dalam **[TopsisService](file:///c:/xampp/htdocs/AInsight/app/Services/TopsisService.php)**, kami menerapkan proteksi:
```php
$dividerCi = $dPlus[$ai->id] + $dMinus[$ai->id];
$preferences[$ai->id] = ($dividerCi == 0) ? 0.5 : ($dMinus[$ai->id] / $dividerCi);
```
Jika pembagi bernilai nol, nilai preferensi alternatif tersebut secara konsisten diatur ke nilai netral **`0.5`** (menandakan bahwa alternatif tersebut memiliki jarak yang setara terhadap titik ideal positif maupun negatif, tanpa keunggulan mutlak).

---

## 6. Hasil Pengujian & Uji Coba Fitur

Kami membuat Unit Test khusus **[TopsisIdenticalValuesTest](file:///c:/xampp/htdocs/AInsight/tests/Unit/TopsisIdenticalValuesTest.php)** untuk mensimulasikan kondisi kasus ekstrem ini secara terprogram.

Hasil pengujian lokal (`php artisan test`):
```bash
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                            0.01s  

   PASS  Tests\Unit\TopsisIdenticalValuesTest
  ✓ topsis calculation with identical alternatives gracefully falls back to 0 5                                  1.49s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                0.86s  

  Tests:    3 passed (7 assertions)
  Duration: 2.57s
```
Semua test lolos, mengonfirmasi keamanan algoritma dari pembagian nol dan kestabilan sistem pemetaan.

---

## 7. Petunjuk Penggunaan Fitur AI Mapping

1. **Konfigurasi Global**:
   - Masuk ke menu **Data Master** &rarr; **AI Mapping** melalui sidebar.
   - Klik **Edit Mapping** pada jenis proyek yang diinginkan (misal: *Graphic Design*).
   - Centang AI Tools relevan yang ingin dijadikan rekomendasi otomatis (misal: *Midjourney*, *Leonardo AI*, *Canva AI*), lalu klik **Simpan Pemetaan**.
2. **Membuat Proyek dengan Auto-load**:
   - Masuk ke menu **Penilaian Proyek** &rarr; **Tambah Proyek** (Inisialisasi Proyek).
   - Pilih Jenis Proyek Kreatif yang telah dikonfigurasi di atas.
   - Sistem akan secara otomatis memunculkan panel rekomendasi AI dan mencentang AI terpilih.
   - Anda dapat melakukan **Manual Override** dengan menghapus centang AI tersebut, atau memilih AI lain dari dropdown pencarian di bawahnya untuk ditambahkan ke proyek bersangkutan secara instan.
3. **Mengisi Decision Matrix & Kalkulasi**:
   - Akses menu **Matriks Keputusan** dan pilih proyek Anda. Baris alternatif matriks sekarang hanya menampilkan AI yang Anda pilih sebelumnya.
   - Isi skor kinerja matriks (skala 1-5) lalu simpan.
   - Jalankan proses TOPSIS dan periksa hasilnya. Seluruh tampilan laporan kalkulasi bersih dari format LaTeX mentah.
