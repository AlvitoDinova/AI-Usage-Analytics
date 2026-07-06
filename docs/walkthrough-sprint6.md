# Walkthrough Sprint 6 — Multi User, Role-Based Access Control (RBAC), Authentication & User Management
## AInsight — Sistem Pendukung Keputusan Pemilihan AI

Dokumen ini mendokumentasikan ringkasan sprint, struktur database baru, seeder default, middleware kustom, pengaturan hak akses, dashboard per role, daftar file baru/berubah, dan hasil pengujian untuk Sprint 6.

---

### 1. Ringkasan Sprint
Pada Sprint 6, aplikasi AInsight telah berhasil bertransformasi dari sistem single-user menjadi aplikasi multi-user dengan hak akses dinamis berbasis Role-Based Access Control (RBAC). 

Sistem membedakan fungsionalitas dan tampilan menu untuk tiga level pengguna: **Administrator**, **Manager**, dan **Employee**, serta mencatat audit trail audit log yang lebih kaya (menyimpan identitas user, role, IP address, dan timestamp).

---

### 2. Struktur Database Baru

#### A. Tabel `users`
Menggunakan enum role dan status, serta mengubah kolom `nama` menjadi `name`:
- `id` (Primary Key)
- `name` (VARCHAR)
- `email` (VARCHAR, Unique)
- `password` (VARCHAR)
- `role` (ENUM: `admin`, `manager`, `employee`, Default: `employee`)
- `status` (ENUM: `active`, `inactive`, Default: `active`)
- `remember_token` (VARCHAR, Nullable)
- `created_at` & `updated_at` (Timestamp)

#### B. Tabel `projects`
Menambahkan kepemilikan proyek:
- `owner_id` (Unsigned Big Integer, Foreign Key referencing `users(id)` ON DELETE CASCADE)

#### C. Tabel `activity_logs`
Menambahkan detail metadata penilai/aktor audit:
- `user` (VARCHAR, Nullable) - Menyimpan nama penilai
- `role` (VARCHAR, Nullable) - Menyimpan role penilai
- `ip_address` (VARCHAR, Nullable) - Menyimpan IP Address client

---

### 3. Akun Default & Seeder
Telah disiapkan tiga akun default di `UserSeeder.php` dengan rincian berikut:

| Nama | Email | Sandi | Role | Status |
| :--- | :--- | :--- | :--- | :--- |
| **Administrator** | admin@ainsight.test | password | `admin` | `active` |
| **Manager** | manager@ainsight.test | password | `manager` | `active` |
| **Employee** | employee@ainsight.test | password | `employee` | `active` |

---

### 4. Custom Middleware & Registrasi
1. **Middleware Kustom (`RoleMiddleware.php`)**:
   Menerapkan variadic parameters `...$roles` untuk memvalidasi apakah penilai yang sedang aktif memiliki role yang sesuai. Apabila user berstatus `inactive`, middleware otomatis mengeluarkan session dan mengalihkan penilai kembali ke halaman login.
2. **Registrasi (`bootstrap/app.php`)**:
   Didaftarkan dengan alias `'role'` sehingga dapat dipanggil langsung dari berkas rute:
   ```php
   $middleware->alias([
       'role' => \App\Http\Middleware\RoleMiddleware::class,
   ]);
   ```

---

### 5. Pembagian Hak Akses (RBAC)

- **ADMINISTRATOR (Full Access)**
  - Mengakses seluruh menu master data, pengaturan bobot, mapping AI, manajemen user, log aktivitas, proyek, detail perhitungan TOPSIS, dan ekspor PDF.
- **MANAGER (Pengawasan & Statistik)**
  - Boleh mengakses: Dashboard Manager, Statistik SPK, Penilaian Proyek (Melihat semua proyek), Riwayat Evaluasi (Melihat semua riwayat), dan Export PDF.
  - Dilarang mengakses: Manajemen User, Data AI Tools, Data Kriteria, Bobot, Jenis Project, AI Mapping, dan Log Aktivitas.
- **EMPLOYEE (Workspace Personal)**
  - Boleh mengakses: Dashboard Employee, Project Saya (hanya proyek miliknya), Input Matriks, Detail Perhitungan, dan Ekspor PDF miliknya.
  - Dilarang mengakses: Master Data, Statistik SPK, Riwayat semua proyek, Log Aktivitas, dan Manajemen User.

---

### 6. Dashboard Berbeda per Role

1. **Dashboard Admin**:
   - Menampilkan total AI tools, total kriteria, total proyek, total evaluasi, rata-rata AI per proyek, list Top 5 AI tools, penjelasan alur SPK TOPSIS, dan quick link.
2. **Dashboard Manager**:
   - Menampilkan widget Jumlah Proyek, Evaluasi Selesai, Proyek Terakhir, dan AI Terbaik Terakhir. Dilengkapi shortcut akses cepat ke daftar Proyek, Riwayat, dan Statistik.
3. **Dashboard Employee**:
   - Menampilkan sambutan personal, widget Project Saya, Project Selesai, dan Project Menunggu Penilaian. Dilengkapi tombol cepat untuk melanjutkan penilaian dan melihat riwayat pribadinya.

---

### 7. Daftar Berkas Baru & Berubah

#### Berkas Baru (New Files)
1. [alter_users_table_for_rbac.php](file:///c:/xampp/htdocs/AInsight/database/migrations/2026_07_05_000001_alter_users_table_for_rbac.php) — Migrasi users.
2. [alter_projects_table_add_owner.php](file:///c:/xampp/htdocs/AInsight/database/migrations/2026_07_05_000002_alter_projects_table_add_owner.php) — Migrasi projects owner.
3. [alter_activity_logs_table_add_rbac.php](file:///c:/xampp/htdocs/AInsight/database/migrations/2026_07_05_000003_alter_activity_logs_table_add_rbac.php) — Migrasi logs audit.
4. [RoleMiddleware.php](file:///c:/xampp/htdocs/AInsight/app/Http/Middleware/RoleMiddleware.php) — Middleware RBAC.
5. [LoginController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/Auth/LoginController.php) — Controller autentikasi.
6. [UserController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/UserController.php) — Controller User CRUD.
7. [StoreUserRequest.php](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/StoreUserRequest.php) — Form Request input user baru.
8. [UpdateUserRequest.php](file:///c:/xampp/htdocs/AInsight/app/Http/Requests/UpdateUserRequest.php) — Form Request ubah user.
9. [login.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/auth/login.blade.php) — View halaman Login.
10. [RbacTest.php](file:///c:/xampp/htdocs/AInsight/tests/Feature/RbacTest.php) — File pengujian RBAC.
11. [dashboard.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/manager/dashboard.blade.php) — Dashboard Manager.
12. [dashboard.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/employee/dashboard.blade.php) — Dashboard Employee.
13. [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/users/index.blade.php) — Halaman User CRUD.
14. [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/users/create.blade.php) — Halaman tambah user.
15. [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/users/edit.blade.php) — Halaman edit user.

#### Berkas Berubah (Modified Files)
1. [UserSeeder.php](file:///c:/xampp/htdocs/AInsight/database/seeders/UserSeeder.php) — Seeder user default.
2. [DatabaseSeeder.php](file:///c:/xampp/htdocs/AInsight/database/seeders/DatabaseSeeder.php) — Seeder project default.
3. [User.php](file:///c:/xampp/htdocs/AInsight/app/Models/User.php) — Model User fields & relasi.
4. [Project.php](file:///c:/xampp/htdocs/AInsight/app/Models/Project.php) — Model Project fields & relasi.
5. [ActivityLog.php](file:///c:/xampp/htdocs/AInsight/app/Models/ActivityLog.php) — Model ActivityLog auto enrichment.
6. [app.php](file:///c:/xampp/htdocs/AInsight/bootstrap/app.php) — Registrasi middleware alias.
7. [web.php](file:///c:/xampp/htdocs/AInsight/routes/web.php) — Grouping routing rute RBAC.
8. [ProjectController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php) — Scoping project list & check ownership.
9. [DecisionMatrixController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DecisionMatrixController.php) — Scoping matrix selection & check ownership.
10. [EvaluationHistoryController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/EvaluationHistoryController.php) — Scoping history index & check ownership.
11. [DashboardController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/DashboardController.php) — Render view sesuai role.
12. [app.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/layouts/app.blade.php) — Menu sidebar kondisional & dropdown profil topbar.
13. [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/activity_logs/index.blade.php) — Modifikasi layout kolom logs.
14. [TopsisInvalidationTest.php](file:///c:/xampp/htdocs/AInsight/tests/Unit/TopsisInvalidationTest.php) — Menambahkan autentikasi aktor sebelum pengujian.
15. [ExampleTest.php](file:///c:/xampp/htdocs/AInsight/tests/Feature/ExampleTest.php) — Menambahkan autentikasi aktor sebelum pengujian dashboard.

---

### 8. Hasil Pengujian Internal
Menjalankan suite pengujian unit dan integrasi fungsional:

```
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                                                            0.01s  

   PASS  Tests\Unit\TopsisIdenticalValuesTest
  ✓ topsis calculation with identical alternatives gracefully falls back to 0 5                                  0.39s  

   PASS  Tests\Unit\TopsisInvalidationTest
  ✓ topsis results are deleted and status resets to draft when ai list changes                                   0.34s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                0.04s  

   PASS  Tests\Feature\RbacTest
  ✓ unauthenticated users are redirected to login                                                                0.03s  
  ✓ users can login with correct credentials                                                                     0.03s  
  ✓ users cannot login with incorrect credentials                                                                0.23s  
  ✓ inactive users cannot login                                                                                  0.03s  
  ✓ admin can access user management and master data                                                             0.03s  
  ✓ manager cannot access user management or master data                                                         0.03s  
  ✓ employee can only see their own projects and history                                                         0.04s  

  Tests:    11 passed (43 assertions)
  Duration: 1.42s
```

Seluruh pengujian berjalan sukses tanpa ada regresi maupun error PHP.
 Kinerja RBAC, login/logout, penolakan akses 403, scoping proyek personal, dan audit trail activity logs berjalan 100% stabil.
