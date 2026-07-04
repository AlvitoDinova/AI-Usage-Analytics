# Walkthrough - Sprint 3: Implementasi Algoritma TOPSIS

Pekerjaan implementasi engine perhitungan algoritma TOPSIS secara manual untuk Sprint 3 telah diselesaikan dengan sukses. Sistem merekomendasikan alternatif AI terbaik bagi agensi Notch berdasarkan karakteristik dan bobot proyek kreatif.

---

### 1. Penjelasan Tahapan & Rumus Algoritma TOPSIS

Seluruh logika matematika TOPSIS dikodekan secara manual pada [TopsisService.php](file:///c:/xampp/htdocs/AInsight/app/Services/TopsisService.php) menggunakan rumus sebagai berikut:

#### Langkah 1: Membentuk Matriks Keputusan ($X$)
Matriks berukuran $m \times n$ ($m$ alternatif AI aktif, $n$ kriteria) yang memuat nilai dasar kinerja alternatif $x_{ij}$ skala 1-5.

#### Langkah 2: Normalisasi Matriks Keputusan ($R$)
Membagi nilai $x_{ij}$ dengan panjang vektor kolom (Euclidean Norm) untuk kriteria $j$:
$$r_{ij} = \frac{x_{ij}}{\sqrt{\sum_{i=1}^{m} x_{ij}^2}}$$
*Catatan:* Dilakukan pengecekan pembagian dengan nol. Jika pembagi bernilai nol, $r_{ij}$ diisi dengan `0.0`.

#### Langkah 3: Matriks Keputusan Terbobot ($Y$)
Pertama, bobot di tingkat proyek ($W_k$) dinormalisasi agar total jumlah bobot sama dengan $1.0$ ($w'_j = \frac{w_j}{\sum w_k}$). Kemudian dikalikan ke matriks $R$:
$$y_{ij} = w'_j \times r_{ij}$$

#### Langkah 4 & 5: Solusi Ideal Positif ($A^+$) & Negatif ($A^-$)
*   **Kriteria Benefit:**
    *   $y_j^+ = \max_i(y_{ij})$
    *   $y_j^- = \min_i(y_{ij})$
*   **Kriteria Cost:**
    *   $y_j^+ = \min_i(y_{ij})$
    *   $y_j^- = \max_i(y_{ij})$

#### Langkah 6: Separation Measure (Jarak Jarak Solusi)
*   Jarak ke Solusi Ideal Positif ($D_i^+$):
    $$D_i^+ = \sqrt{\sum_{j=1}^{n} (y_{ij} - y_j^+)^2}$$
*   Jarak ke Solusi Ideal Negatif ($D_i^-$):
    $$D_i^- = \sqrt{\sum_{j=1}^{n} (y_{ij} - y_j^-)^2}$$

#### Langkah 7: Nilai Preferensi ($C_i$) & Perankingan
Menghitung skor akhir kedekatan kedekatan relatif:
$$C_i = \frac{D_i^-}{D_i^+ + D_i^-}$$
Hasil diurutkan berdasarkan skor $C_i$ secara descending (terbesar ke terkecil) untuk memperoleh peringkat rekomendasi AI terbaik.

---

### 2. Berkas & Komponen yang Dibuat / Diubah

1.  **[TopsisService](file:///c:/xampp/htdocs/AInsight/app/Services/TopsisService.php):** Engine service mandiri untuk kalkulasi TOPSIS dan penyimpanan log audit kalkulasi secara detail.
2.  **[ProjectController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php):** Menampung aksi `calculateTopsis()`, halaman rendering `results()`, dan rendering detail `calculationDetails()`.
3.  **[routes/web.php](file:///c:/xampp/htdocs/AInsight/routes/web.php):** Penambahan rute kalkulasi, rute hasil perankingan, dan rute audit langkah desimal perhitungan.
4.  **Tampilan Blade Baru:**
    *   [results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php): Banner hijau premium penampil rekomendasi AI nomor 1 dan tabel urutan ranking.
    *   [calculation.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/calculation.blade.php): Halaman audit matematika desimal TOPSIS berbasis tab navigasi.
5.  **Dashboard Widget:**
    *   [DashboardController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DashboardController.php) & [dashboard.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/user/dashboard.blade.php): Ditambahkan widget Total Evaluasi TOPSIS, AI Terbaik Terakhir, dan Proyek Terakhir Dievaluasi.

---

### 3. Hasil Pengujian Verifikasi
*   **Akurasi Matematika:** Pengujian integrasi HTTP stack menunjukkan nilai preferensi $C_i$ terhitung akurat dan tersimpan rapi di basis data MySQL (`topsis_results` dan `calculation_logs`).
*   **Activity Logs:** Audit trail berhasil mencatat stempel waktu dan status eksekusi Administrator saat memproses TOPSIS.
*   **Update Dashboard:** Widget terupdate real-time secara dinamis dari database tanpa hardcode.
