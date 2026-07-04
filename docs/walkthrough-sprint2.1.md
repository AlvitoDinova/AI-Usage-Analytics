# Walkthrough - Sprint 2.1: Bug Fix & Data Integrity

Pekerjaan perbaikan bug dan integritas data untuk Sprint 2.1 telah diselesaikan dengan sukses. Seluruh isolasi data per proyek dan navigasi ke halaman Coming Soon telah teratasi dengan baik.

---

### 1. Bug yang Ditemukan & Solusi

#### Bug 1: Redundansi Penyimpanan Matriks Keputusan Antar Proyek
*   **Gejala:** Mengedit matriks keputusan pada Proyek A menyebabkan matriks Proyek B ikut berubah secara tidak terduga.
*   **Penyebab:** Kolom kunci pencari di tabel `matrix_values` hanya memetakan kombinasi `[ai_id, criteria_id]` secara global tanpa menyertakan konteks id proyek (`project_id`).
*   **Solusi:**
    1. Membuat migrasi baru [2025_01_02_000002_add_project_id_to_matrix_values_table](file:///c:/xampp/htdocs/AInsight/database/migrations/2025_01_02_000002_add_project_id_to_matrix_values_table.php) untuk menambahkan kolom `project_id` dan mengubah index unik menjadi `['project_id', 'ai_id', 'criteria_id']`.
    2. Mengupdate logic query penyimpanan `updateOrCreate` pada [DecisionMatrixController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DecisionMatrixController.php) dan logic query detail di [ProjectController](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php) agar terfilter menggunakan `project_id`.
*   **File yang diubah:**
    *   [database/migrations/2025_01_02_000002_add_project_id_to_matrix_values_table.php](file:///c:/xampp/htdocs/AInsight/database/migrations/2025_01_02_000002_add_project_id_to_matrix_values_table.php)
    *   [app/Models/MatrixValue.php](file:///c:/xampp/htdocs/AInsight/app/Models/MatrixValue.php)
    *   [app/Http/Controllers/DecisionMatrixController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DecisionMatrixController.php)
    *   [app/Http/Controllers/ProjectController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php)
    *   [database/seeders/DatabaseSeeder.php](file:///c:/xampp/htdocs/AInsight/database/seeders/DatabaseSeeder.php)
    *   [database/seeders/MatrixValueSeeder.php](file:///c:/xampp/htdocs/AInsight/database/seeders/MatrixValueSeeder.php)

#### Bug 2: Penayangan Matriks Keputusan di Detail Proyek (Show)
*   **Gejala:** Tabel matriks keputusan belum termuat saat membuka halaman detail proyek.
*   **Penyebab:** Komponen penampil data matriks belum membaca variabel penampung data terisolasi.
*   **Solusi:** Menambahkan tabel audit matriks keputusan yang memetakan performa alternatif AI terhadap kriteria khusus untuk proyek tersebut pada `projects/show.blade.php`.
*   **File yang diubah:** [resources/views/admin/projects/show.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/show.blade.php)

#### Bug 3: Validasi Masukan Form Proyek
*   **Gejala:** Mengabaikan validasi input server-side.
*   **Penyebab:** Hanya mengandalkan validasi HTML5.
*   **Solusi:** Menyusun validasi Form Request kustom [StoreProjectRequest](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreProjectRequest.php) dengan pesan error terjemahan Bahasa Indonesia.
*   **File yang diubah:** [app/Http/Requests/StoreProjectRequest.php](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreProjectRequest.php)

#### Bug 4: Menu "Riwayat Evaluasi" Terbuka Kosong (Anchor Link)
*   **Gejala:** Menggunakan tautan jangkar `#history` di menu sidebar.
*   **Penyebab:** Halaman riwayat belum dibuat karena dijadwalkan pada Sprint selanjutnya.
*   **Solusi:** Membuat halaman Coming Soon [coming-soon.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/errors/coming-soon.blade.php) dan menghubungkan rutenya pada sidebar.
*   **File yang diubah:**
    *   [resources/views/layouts/app.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/layouts/app.blade.php)
    *   [routes/web.php](file:///c:/xampp/htdocs/AInsight/routes/web.php)
    *   [resources/views/errors/coming-soon.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/errors/coming-soon.blade.php)

---

### 2. Hasil Pengujian Verifikasi
*   **Uji Isolasi Database:** Berhasil dijalankan menggunakan perintah Tinker. Terbukti modifikasi data matriks keputusan pada Proyek A **tidak memengaruhi** nilai matriks keputusan pada Proyek B.
*   **Akses Menu Riwayat:** Tautan menu riwayat evaluasi di sidebar berhasil mengarah ke halaman Coming Soon.
*   **Pesan Error Validasi:** Tampil dengan jelas menggunakan Bahasa Indonesia ketika input form dikirim kosong.
