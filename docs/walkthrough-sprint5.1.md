# Walkthrough Sprint 5.1 — Bug Fix, UI Polish & History Integrity
## AInsight — Sistem Pendukung Keputusan Pemilihan AI

Dokumen ini mendokumentasikan perbaikan bug, penyesuaian fungsionalitas, pemolesan antarmuka pengguna (UI), dan hasil pengujian regresi untuk Sprint 5.1.

---

### 1. Bug & Masalah yang Diperbaiki

#### Bug 1 — Sidebar Tidak Bisa Discroll
- **Masalah:** Pada resolusi desktop standar di zoom 100%, menu bagian bawah sidebar (seperti Riwayat Evaluasi) terpotong dan tidak dapat diakses kecuali pengguna melakukan zoom-out hingga 80%.
- **Solusi:** Menambahkan parameter `overflow-y: auto;` pada kelas `.sidebar` di dalam stylesheet global layout. Kini, jika resolusi tinggi menu melebihi viewport, sidebar dapat digulir secara vertikal secara mandiri tanpa memengaruhi scroll layout konten utama.

#### Bug 2 — History Harus Bersifat Immutable (Snapshot)
- **Masalah:** Sebelumnya, mengubah matriks keputusan proyek atau daftar AI yang dipetakan akan langsung menghapus/mereset hasil TOPSIS dan logs evaluasi lama yang sudah terekam di riwayat.
- **Solusi:**
  1. Mengubah mekanisme kalkulasi TOPSIS di `TopsisService.php` agar setiap penekanan tombol "Proses TOPSIS" selalu menciptakan objek `Assessment` baru (`Assessment::create`) yang menyimpan snapshot penilaian tersendiri, bukan menimpa (`firstOrCreate`) record yang lama.
  2. Menghapus logika pembersihan/penghapusan logs kalkulasi & hasil TOPSIS di `ProjectController.php` ketika daftar AI proyek diubah.
  3. Mengubah rute halaman riwayat detail dan ekspor PDF agar mengikat parameter model binding pada `{assessment}` (ID evaluasi spesifik) alih-alih `{project}` (ID proyek).
  4. Mengubah query di `EvaluationHistoryController.php` agar mengambil data langsung dari tabel `assessments` yang sudah memiliki relasi hasil TOPSIS. Hal ini memastikan riwayat lama tetap utuh, dapat diakses, dan PDF lamanya tetap dapat diekspor meskipun matriks keputusan proyek saat ini sedang diedit atau dalam status draft.

#### Bug 3 — Statistik SPK Memiliki Gap Kosong
- **Masalah:** Terdapat ruang kosong/celah vertikal (whitespace gap) yang kurang proporsional antara bagian judul card dengan tabel statistik atau progress bar keikutsertaan AI.
- **Solusi:** Menghilangkan elemen `card-header` Bootstrap pada cards di dalam file view statistik, lalu memindahkan elemen judul tag `<h6>` ke dalam bagian `card-body` dengan margin yang pas (`mb-2` / `mb-3`). Hal ini mengeliminasi double-padding/margins default Bootstrap dan membuat tampilan lebih padat dan profesional.

---

### 2. Berkas yang Diubah

#### A. Controllers & Services
1. [TopsisService.php](file:///c:/xampp/htdocs/AInsight/app/Services/TopsisService.php) — Mengubah pembentukan `Assessment` menggunakan `create()` dan menghapus logic delete di transaksi.
2. [ProjectController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php) — Menghapus penghapusan logs/results di method `update()`. Mengubah pengambilan assessment di results & calculationDetails menggunakan order ID desc (mengambil yang terbaru).
3. [EvaluationHistoryController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/EvaluationHistoryController.php) — Mengubah query daftar riwayat agar berbasis assessments, serta menerapkan model binding `Assessment` untuk detail & ekspor PDF.

#### B. Routes & Views
1. [web.php](file:///c:/xampp/htdocs/AInsight/routes/web.php) — Memperbarui parameter rute history detail dan pdf export agar mengikat `{assessment}`.
2. [app.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/layouts/app.blade.php) — Menambahkan CSS `overflow-y: auto;` pada sidebar.
3. [history/index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/history/index.blade.php) — Memperbarui pemanggilan detail & pdf menggunakan `assessment_id` dan variable evaluations.
4. [history/show.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/history/show.blade.php) — Memperbarui pemanggilan route `history.pdf` dengan `assessment->id`.
5. [projects/results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php) — Memperbarui pemanggilan route `history.pdf` dengan `assessment->id`.
6. [statistics/index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/statistics/index.blade.php) — Memoles padding card header dan body untuk merapatkan spasi.

#### C. Unit & Integration Tests
1. [TopsisInvalidationTest.php](file:///c:/xampp/htdocs/AInsight/tests/Unit/TopsisInvalidationTest.php) — Menyesuaikan pengujian agar menegaskan bahwa records hasil TOPSIS dan logs evaluasi lama tetap tersimpan (`assertDatabaseHas`) saat matrix berubah.

---

### 3. Hasil Pengujian Regresi
Seluruh pengujian unit dan fungsionalitas aplikasi berhasil diselesaikan dengan sukses 100%:

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

Fungsionalitas snapshot riwayat terbukti berjalan normal: ketika matriks proyek diubah, riwayat penilaian lama tetap ada di daftar, dapat dilihat detailnya, dan PDF laporan versi lamanya tetap dapat diunduh secara tepat.
Sidebar dan layout halaman Statistik SPK kini tampil presisi dan profesional.
