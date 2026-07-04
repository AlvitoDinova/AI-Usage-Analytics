# Walkthrough - Sprint 1: Master Data CRUD

Pekerjaan Sprint 1 telah selesai dilakukan dengan sukses. Seluruh data master (AI Tools, Kriteria, Bobot Kriteria, dan Jenis Proyek) telah terhubung sepenuhnya dengan MySQL melalui Eloquent ORM di Laravel 12.

---

### 1. Ringkasan Pekerjaan Sprint 1
*   **Pengalihan Rute Sidebar:** Mengganti semua tautan sidebar statis `#` menjadi named routes Laravel riil.
*   **AI Tools CRUD:**
    *   Pengelolaan AI alternatif (tambah, edit, detail, hapus).
    *   Fitur pencarian terintegrasi dan pembagi halaman (*pagination*).
    *   Pengapusan data dilindungi dengan modal konfirmasi SweetAlert2.
*   **Kriteria CRUD:**
    *   Pengelolaan kriteria penilaian TOPSIS (Benefit/Cost).
*   **Bobot Kriteria (100% Validation):**
    *   Form pengubah nilai default kriteria massal.
    *   Validasi backend menjamin total jumlah bobot harus tepat **100%**.
    *   JavaScript dinamis untuk menjumlahkan bobot masukan saat admin mengetik angka di form.
*   **Jenis Proyek CRUD:**
    *   Pengelolaan kategori proyek agensi kreatif Notch.
    *   Pencegahan penghapusan jenis proyek jika masih digunakan oleh entitas transaksi.

---

### 2. Daftar Komponen yang Dibuat

#### Controller Baru
1.  **[AIToolController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/AIToolController.php):** Mengelola CRUD, search, pagination, dan update cache statistik dashboard.
2.  **[CriterionController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/CriterionController.php):** Mengelola CRUD dan update cache statistik kriteria.
3.  **[CriterionWeightController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/CriterionWeightController.php):** Mengelola input bobot massal dengan validasi 100%.
4.  **[ProjectTypeController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectTypeController.php):** Mengelola CRUD kategori proyek.

#### Form Request Validation
1.  **[StoreAIToolRequest](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreAIToolRequest.php):** Validasi data AI (nama unik, website URL valid, status enum).
2.  **[StoreCriterionRequest](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreCriterionRequest.php):** Validasi kriteria (kode unik, tipe Benefit/Cost).
3.  **[StoreProjectTypeRequest](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreProjectTypeRequest.php):** Validasi keunikan kategori proyek.

#### Rute Baru (`routes/web.php`)
```php
Route::resource('ai-tools', AIToolController::class);
Route::resource('criteria', CriterionController::class);
Route::resource('criterion-weights', CriterionWeightController::class)->only(['index', 'store']);
Route::resource('project-types', ProjectTypeController::class);
```

#### Tampilan Blade Baru
*   **AI Tools:** [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai/index.blade.php) | [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai/create.blade.php) | [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai/edit.blade.php) | [show.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai/show.blade.php)
*   **Kriteria:** [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/criteria/index.blade.php) | [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/criteria/create.blade.php) | [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/criteria/edit.blade.php)
*   **Bobot Kriteria:** [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/weights/index.blade.php)
*   **Jenis Proyek:** [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/project-types/index.blade.php) | [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/project-types/create.blade.php) | [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/project-types/edit.blade.php)

---

### 3. Hasil Pengujian Verifikasi
*   Semua rute CRUD terdaftar di `php artisan route:list`.
*   Aksi penambahan, pembaruan, dan penghapusan data master berhasil ter-update di database MySQL.
*   **Dashboard Dynamic Update:** Saat menambahkan data AI baru, cache statistik `total_ai_tools` di database ter-update secara otomatis dan ter-render di Dashboard utama secara real-time.
*   **Visual Check:** Layout responsif Bootstrap 5, alerts notification, dan modal konfirmasi SweetAlert2 berjalan tanpa hambatan visual.
