# Walkthrough - Sprint 2: Penilaian Proyek & Matriks Keputusan

Pekerjaan Sprint 2 telah selesai dilakukan dengan sukses. Sistem inisialisasi penilaian proyek agensi dan grid editor matriks keputusan global telah terhubung sepenuhnya dengan MySQL melalui Eloquent ORM di Laravel 12.

---

### 1. Ringkasan Pekerjaan Sprint 2
*   **Migrasi & Perubahan Kolom Proyek:** Membuat migrasi penambahan kolom `client` (string), `status` (enum: Draft/Dinilai/Selesai), dan `tanggal` (date) pada tabel `projects` dan mengeksekusinya di basis data MySQL.
*   **CRUD Penilaian Proyek:**
    *   Pengelolaan inisialisasi proyek agensi kreatif Notch (tambah, edit, detail, hapus).
    *   Penggunaan custom validation FormRequest.
    *   Paginasi, pencarian terintegrasi, dan konfirmasi hapus data berbasis SweetAlert2.
*   **Matriks Keputusan (Grid Editor):**
    *   Editor grid silang alternatif AI aktif × kriteria aktif.
    *   Skala penilaian dropdown dropdown 1-5 dengan validasi backend ketat.
    *   Penyimpanan baris data menggunakan Database Transactions (`DB::transaction`) untuk menjaga konsistensi.
    *   Mengubah status proyek otomatis menjadi **Dinilai** setelah data matriks disimpan.
*   **Dynamic Dashboard Update:** Metrik ringkasan dashboard (Total Proyek & Total Penilaian) ter-recount secara dinamis langsung dari database.

---

### 2. Daftar Komponen yang Dibuat

#### Berkas Migrasi Baru
1.  **[2025_01_02_000001_add_columns_to_projects_table](file:///c:/xampp/htdocs/AInsight/database/migrations/2025_01_02_000001_add_columns_to_projects_table.php):** Menambahkan `client`, `status`, dan `tanggal` pada tabel `projects`.

#### Controller Baru
1.  **[ProjectController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php):** Menangani CRUD proyek, pencarian, pembagian halaman, dan penampilan detail proyek beserta visualisasi matriks keputusan.
2.  **[DecisionMatrixController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DecisionMatrixController.php):** Menangani penampilan dropdown pilihan proyek dan form grid pengisian nilai kriteria alternatif AI (1-5) berbasis transaksi database.

#### Form Request Validation
1.  **[StoreProjectRequest](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreProjectRequest.php):** Validasi data proyek agensi (nama proyek, client, jenis proyek, tanggal, status enum, deskripsi).

#### Rute Baru (`routes/web.php`)
```php
Route::resource('projects', ProjectController::class);
Route::get('matrix', [DecisionMatrixController::class, 'index'])->name('matrix.index');
Route::post('matrix', [DecisionMatrixController::class, 'store'])->name('matrix.store');
```

#### Tampilan Blade Baru
*   **Proyek:** [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/index.blade.php) | [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/create.blade.php) | [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/edit.blade.php) | [show.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/show.blade.php)
*   **Matriks Keputusan:** [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/matrix/index.blade.php)

---

### 3. Hasil Pengujian Verifikasi
*   **Route List:** 37 rute terdaftar dengan sukses (`php artisan route:list`).
*   **Database Transaction:** Penyimpanan skor matriks berjalan lancar secara atomik.
*   **Status Transitions:** Proyek berstatus awal "Draft" terbukti otomatis berpindah ke status "Dinilai" setelah pengisian matriks keputusan disimpan.
*   **Widget Dashboard:** Widget ringkasan dashboard terverifikasi berubah secara dinamis sesuai jumlah data terbaru dari database.
