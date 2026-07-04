# Walkthrough - Audit & Critical Bug Fix Sprint 3

Berkas ini mendokumentasikan proses audit komprehensif, penyebab critical bug, serta penanganan defensive programming untuk memastikan modul TOPSIS berjalan stabil dan andal.

---

### 1. Penyebab Bug Utama & Solusi

#### Bug 1: ErrorException di `results.blade.php` (foreach argument null given)
*   **Penyebab:** Kesalahan nama relasi di file view [results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php). Penulisan awal menggunakan `$assessment->assessmentDetails`, padahal nama fungsi relasi yang dideklarasikan di model [Assessment](file:///c:/xampp/htdocs/AInsight/app/Models/Assessment.php) adalah `details()`. Akibatnya, Laravel mengembalikan nilai `null` yang memicu crash pada fungsi perulangan `foreach`.
*   **Solusi:**
    1. Mengubah kode pemanggilan relasi di view [results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php) menjadi `$assessment->details`.
    2. Menghindari crash akibat kegagalan eksekusi model dengan mengganti `firstOrFail()` menjadi `first()`, lalu mengirimkan `Collection` kosong atau array kosong jika data tidak ditemukan (Defensive Programming).
*   **File yang diperbaiki:**
    *   [app/Http/Controllers/ProjectController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php)
    *   [resources/views/admin/projects/results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php)
    *   [resources/views/admin/projects/calculation.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/calculation.blade.php)

---

### 2. Defensive Programming & Penanganan State Kosong

1.  **Peta Hasil Perangkingan Kosong:** Di halaman hasil evaluasi (`projects/{id}/results`), jika penilaian TOPSIS belum diproses (atau `$results` kosong), sistem tidak lagi crash melainkan menampilkan banner peringatan:
    > **"Belum Ada Hasil Evaluasi"**
    > Proyek ini belum dievaluasi menggunakan metode TOPSIS. Silakan jalankan proses perhitungan terlebih dahulu.
2.  **Peta Detail Perhitungan Kosong:** Di halaman audit perhitungan (`projects/{id}/calculation`), jika data langkah desimal tidak ditemukan di `calculation_logs`, sistem menampilkan pesan:
    > **"Detail Perhitungan Tidak Tersedia"**
    > Detail perhitungan matematika desimal belum terbuat. Silakan jalankan proses perhitungan TOPSIS terlebih dahulu.

---

### 3. Alur Perhitungan Matematika TOPSIS (Hasil Audit)

Proses kalkulasi pada [TopsisService.php](file:///c:/xampp/htdocs/AInsight/app/Services/TopsisService.php) diverifikasi mematuhi tahapan sebagai berikut:
1.  **Decision Matrix (Matriks Awal X):** Membaca performa AI Alternatif (1-5) dari database MySQL.
2.  **Normalization (Matriks Ternormalisasi R):** Normalisasi dengan pembagi Euclidean Norm $\sqrt{\sum x^2}$.
3.  **Weighted Matrix (Matriks Terbobot Y):** Menormalkan bobot masukan kriteria agar berjumlah tepat 1.0, lalu dikalikan dengan matriks R.
4.  **Ideal Positive ($A^+$) & Ideal Negative ($A^-$):** Penentuan koordinat ideal berdasarkan jenis kriteria (Benefit / Cost).
5.  **D+ & D- (Separation Measure):** Jarak alternatif ke titik ideal positif dan negatif.
6.  **Preference (Nilai Preferensi):** Perhitungan nilai kedekatan relatif $C_i = \frac{D_i^-}{D_i^+ + D_i^-}$.
7.  **Ranking (Perankingan):** Pengurutan menurun (descending) untuk memperoleh alternatif peringkat terbaik.

---

### 4. Hasil Verifikasi Sistem

Hasil uji coba terintegrasi menunjukkan respon sukses:
*   `rankings_count`: 13 alternatif AI Tools diproses secara komparatif.
*   `results_db`: 13 baris peringkat berhasil disimpan ke tabel `topsis_results`.
*   `logs_db`: 8 tahapan detail desimal berhasil disimpan ke `calculation_logs`.
*   `view_render_status`: `success` (halaman hasil berhasil dikompilasi tanpa ada error).
