# Walkthrough - Sprint 4.1: Bug Fix & Stabilization

Dokumen ini menjelaskan detail perbaikan bug dan stabilisasi antarmuka pengguna (UI) yang diselesaikan pada Sprint 4.1.

---

## 1. Perbaikan Bug 1: Hasil TOPSIS Harus Invalid Saat AI Berubah

### 1.1 Masalah
Saat administrator mengubah daftar alternatif AI pada proyek yang sudah memiliki hasil evaluasi (baik penambahan, penghapusan, atau pergantian AI), halaman **Hasil Evaluasi** masih menampilkan hasil perankingan dari perhitungan lama. Hal ini menyebabkan ketidaksinkronan data visual di frontend dengan konfigurasi data di backend.

### 1.2 Solusi & Penjelasan Implementasi
1. **Pendeteksian Perubahan AI**: Di dalam **[ProjectController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php)** method `update()`, kami membandingkan array ID alternatif AI lama yang terasosiasi dengan proyek dengan data baru dari input form request.
2. **Reset Status & Hapus Hasil**: Jika terdeteksi perubahan pada daftar AI:
   - Status proyek otomatis dipaksa kembali menjadi **`Draft`** (karena matriks keputusan perlu diisi ulang untuk AI baru).
   - Data perhitungan lama di tabel `topsis_results` dan `calculation_logs` yang terhubung ke assessment proyek langsung dihapus secara bersih.
3. **Pemberitahuan UI**: Pada halaman **Hasil Evaluasi** (**[results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php)**), kami menambahkan pengecekan kondisi. Jika hasil (`$results`) kosong tetapi sesi penilaian (`$assessment`) sudah pernah ada sebelumnya (menandakan hasil telah direset karena AI berubah), sistem akan menampilkan pesan informasi Bootstrap:
   - **Judul**: "Hasil Evaluasi Belum Tersedia"
   - **Isi**: "Alternatif AI pada proyek telah berubah sehingga hasil evaluasi sebelumnya sudah tidak berlaku. Silakan jalankan kembali proses TOPSIS untuk memperoleh hasil terbaru."
   - **Tombol**:
     1. *Kembali ke Detail Project*: Mengarahkan kembali ke halaman detail proyek.
     2. *Proses TOPSIS*: Menjalankan perhitungan ulang secara manual melalui metode POST (sistem tidak menghitung ulang secara otomatis demi efisiensi).

---

## 2. Perbaikan Bug 2: UI Gap pada Detail Perhitungan

### 2.1 Masalah
Pada halaman Detail Perhitungan TOPSIS, khususnya untuk tab *C. Matriks Ternormalisasi Berbobot*, *D-E. Solusi Ideal*, dan *F-H. Jarak dan Nilai Preferensi*, terdapat ruang kosong (*whitespace*) vertikal yang sangat besar di antara navigasi tab pil dan tabel data di bawahnya.

### 2.2 Solusi & Penjelasan Implementasi
Masalah ini diidentifikasi berasal dari kesalahan DOM nesting pada tab pertama (*A. Matriks Keputusan Awal*) di file **[calculation.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/calculation.blade.php)**. 
Tag pembuka `<div class="card">` untuk tab pertama terhapus secara tidak sengaja pada sprint sebelumnya. Akibatnya:
- Tag penutup `</div>` kartu menutup tab-pane secara prematur.
- Tag penutup tab-pane berikutnya menutup seluruh kontainer `<div class="tab-content" id="topsisTabContent">` lebih awal.
- Semua tab lainnya (B, C, D-E, F-H) ter-render di luar pembungkus tab-content, sehingga susunan tata letak Bootstrap menjadi rusak dan memicu margin kosong yang masif di peramban.

Kami telah memperbaiki tag pembuka `<div class="card">` tersebut. Seluruh tab kalkulasi kini terbungkus dengan rapi di dalam `tab-content` dan tampil rapat langsung setelah judul tab masing-masing tanpa gap whitespace.

---

## 3. File yang Diubah
1. **[ProjectController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php)**: Mengimplementasikan logika pembandingan daftar AI, reset status proyek ke `Draft`, dan pembersihan data hasil lama.
2. **[results.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/results.blade.php)**: Mengintegrasikan alert "Hasil Evaluasi Belum Tersedia" beserta tombol navigasi & submit kalkulasi ulang.
3. **[calculation.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/calculation.blade.php)**: Menyeimbangkan tag pembuka/penutup kartu Bootstrap untuk memulihkan struktur layout tab.
4. **[ExampleTest.php](file:///c:/xampp/htdocs/AInsight/tests/Feature/ExampleTest.php)**: Mengaktifkan trait `RefreshDatabase` agar test berjalan sukses dengan database in-memory.

---

## 4. Hasil Pengujian

### 4.1 Automated Testing
Kami menambahkan pengujian unit terprogram baru di **[TopsisInvalidationTest.php](file:///c:/xampp/htdocs/AInsight/tests/Unit/TopsisInvalidationTest.php)** untuk menguji:
1. Penentuan status proyek yang otomatis kembali ke `Draft` saat daftar AI berubah.
2. Keberhasilan penghapusan data lama di `topsis_results` dan `calculation_logs`.
3. Keberhasilan sinkronisasi relasi pivot dan penghapusan data nilai matriks dari AI yang dihapus.

Hasil eksekusi test suite:
```bash
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                            0.18s  

   PASS  Tests\Unit\TopsisIdenticalValuesTest
  ✓ topsis calculation with identical alternatives gracefully falls back to 0 5                                  4.24s  

   PASS  Tests\Unit\TopsisInvalidationTest
  ✓ topsis results are deleted and status resets to draft when ai list changes                                   0.84s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                0.15s  

  Tests:    4 passed (19 assertions)
  Duration: 9.04s
```
Seluruh pengujian sukses dan lolos uji regresi.
