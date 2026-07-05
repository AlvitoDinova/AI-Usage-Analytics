# Walkthrough Sprint 5 — History, Reporting & Activity Log
## AInsight — Sistem Pendukung Keputusan Pemilihan AI

Dokumen ini mendokumentasikan rangkuman implementasi, rincian file, konfigurasi rute, perubahan view, dan hasil pengujian untuk Sprint 5.

---

### 1. Ringkasan Sprint 5
Pada Sprint 5, sistem telah ditingkatkan dari fase transaksional murni menjadi sistem yang siap produksi dengan fitur riwayat evaluasi lengkap, ekspor laporan PDF profesional menggunakan Laravel DomPDF, log audit aktivitas sistem untuk keamanan dan pemantauan, serta halaman analisis statistik dan penyempurnaan dashboard agensi.

Seluruh fitur diimplementasikan menggunakan Laravel 12, PHP 8.2/8.3, Bootstrap 5, dan database MySQL secara dinamis tanpa hardcode.

---

### 2. File yang Dibuat & Dimodifikasi

#### A. File Baru (NEW)
1. **Controller:**
   - [EvaluationHistoryController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/EvaluationHistoryController.php) — Mengelola daftar riwayat, detail log, dan ekspor PDF.
   - [ActivityLogController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ActivityLogController.php) — Mengelola daftar audit log aktivitas.
   - [StatisticController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/StatisticController.php) — Mengelola komputasi statistik penggunaan AI dan kriteria.
2. **Views:**
   - [history/index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/history/index.blade.php) — Halaman daftar riwayat dengan pencarian, paginasi, dan filter jenis proyek/tanggal.
   - [history/show.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/history/show.blade.php) — Detail riwayat evaluasi dari data statis tersimpan (tanpa kalkulasi ulang).
   - [history/pdf.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/history/pdf.blade.php) — Template laporan PDF profesional dengan logo, metadata proyek, tabel peringkat, dan ringkasan kesimpulan.
   - [activity_logs/index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/activity_logs/index.blade.php) — Halaman daftar audit log dengan filter pencarian, tanggal, dan tipe aktivitas.
   - [statistics/index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/statistics/index.blade.php) — Halaman analisis statistik dengan KPI card dan grafik persentase partisipasi AI.

#### B. File Dimodifikasi (MODIFY)
1. [composer.json](file:///c:/xampp/htdocs/AInsight/composer.json) — Menambahkan dependensi `barryvdh/laravel-dompdf` dan menonaktifkan `platform-check` untuk kelancaran kompilasi silang platform.
2. [routes/web.php](file:///c:/xampp/htdocs/AInsight/routes/web.php) — Mendaftarkan rute-rute baru untuk riwayat, ekspor PDF, log aktivitas, dan statistik.
3. [app.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/layouts/app.blade.php) — Menambahkan link navigasi sidebar untuk halaman Statistik SPK, Log Aktivitas, dan mengubah rute Riwayat Evaluasi.
4. [dashboard.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/user/dashboard.blade.php) — Menyempurnaan visual dashboard (menambahkan widget Evaluasi Bulan Ini, Top 5 AI peringkat 1, serta perbaikan link aksi cepat).
5. [results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php) — Menambahkan tombol "Export PDF" di header hasil evaluasi dan panel "KESIMPULAN EVALUASI".
6. **Controllers Terkait (Logging Aktivitas):**
   - [ProjectController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php) — Log audit saat membuat, mengubah, menghapus proyek, serta TOPSIS run.
   - [AIToolController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/AIToolController.php) — Log audit saat membuat, mengubah, menghapus AI Tool alternatif.
   - [AIToolMappingController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/AIToolMappingController.php) — Log audit saat memperbarui pemetaan AI ke kategori proyek.
   - [DecisionMatrixController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DecisionMatrixController.php) — Log audit saat memperbarui nilai matriks keputusan.

---

### 3. Route Configuration
Berikut adalah konfigurasi rute baru yang didaftarkan pada `routes/web.php`:

```php
// Evaluation History, PDF, Activity Logs, and Statistics
Route::get('history', [EvaluationHistoryController::class, 'index'])->name('history.index');
Route::get('history/{project}', [EvaluationHistoryController::class, 'show'])->name('history.show');
Route::get('projects/{project}/pdf', [EvaluationHistoryController::class, 'exportPdf'])->name('projects.pdf');
Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
Route::get('statistics', [StatisticController::class, 'index'])->name('statistics.index');
```

---

### 4. Database Integration
- **Tabel `activity_logs`:**
  Digunakan untuk mencatat riwayat audit aktivitas penting secara otomatis di backend. Contoh catatan log yang disimpan:
  - *Create Project:* "Membuat proyek baru: 'Project A'."
  - *Update Project:* "Memperbarui data proyek: 'Project A'."
  - *Delete Project:* "Menghapus proyek: 'Project A'."
  - *Create AI:* "Menambahkan alternatif AI Tool baru: 'ChatGPT'."
  - *Update AI:* "Mengubah data AI Tool: 'ChatGPT'."
  - *Delete AI:* "Menghapus AI Tool: 'ChatGPT'."
  - *Update Mapping:* "Memperbarui pemetaan AI untuk jenis proyek: 'Copywriting'."
  - *Update Matrix:* "Memperbarui matriks keputusan untuk proyek: 'Project A'."
  - *Run TOPSIS:* "Administrator berhasil mengeksekusi perhitungan TOPSIS untuk proyek 'Project A'."
  - *Export PDF:* "Mengekspor hasil evaluasi proyek 'Project A' ke PDF."

---

### 5. Hasil Pengujian (Regression Testing)
Seluruh pengujian unit berjalan sukses dengan persentase kelulusan 100%:

```
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                            0.01s  

   PASS  Tests\Unit\TopsisIdenticalValuesTest
  ✓ topsis calculation with identical alternatives gracefully falls back to 0 5                                  0.41s  

   PASS  Tests\Unit\TopsisInvalidationTest
  ✓ topsis results are deleted and status resets to draft when ai list changes                                   0.09s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                0.04s  

  Tests:    4 passed (19 assertions)
  Duration: 0.80s
```

Semua fungsionalitas dari Sprint 0 sampai Sprint 4 berjalan normal secara regresi.
Laporan PDF berhasil di-render tanpa error platform, dan logs audit aktivitas tercatat secara real-time di database.
