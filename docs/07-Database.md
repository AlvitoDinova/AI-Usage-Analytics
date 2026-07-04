# Database Design Document (07-Database.md)
## Sistem Pendukung Keputusan Pemilihan Penggunaan AI pada Industri Kreatif di Notch Creative Agency Menggunakan Metode TOPSIS (AInsight)

---

### 1. ERD (Entity Relationship Diagram)
Desain relasi database digambarkan melalui diagram relasi entitas berikut:

```mermaid
erDiagram
    ROLES ||--o{ USERS : "contains"
    USERS ||--o{ PROJECTS : "creates"
    PROJECT_TYPES ||--o{ PROJECTS : "categorizes"
    PROJECTS ||--1| ASSESSMENTS : "has"
    ASSESSMENTS ||--|{ ASSESSMENT_DETAILS : "contains"
    CRITERIA ||--o{ ASSESSMENT_DETAILS : "rated in"
    CRITERIA ||--o{ MATRIX_VALUES : "defines score"
    AI_TOOLS ||--o{ MATRIX_VALUES : "evaluated in"
    ASSESSMENTS ||--o{ TOPSIS_RESULTS : "ranks"
    AI_TOOLS ||--o{ TOPSIS_RESULTS : "scores"
    ASSESSMENTS ||--o{ CALCULATION_LOGS : "logs"
```

---

### 2. Skema Tabel & Detail Kolom

#### 2.1 roles
Menyimpan peran akses pengguna dalam aplikasi.
* `id` (INT, Primary Key, Auto Increment)
* `nama_role` (VARCHAR(50), Unique)

#### 2.2 users
Menyimpan informasi kredensial akun pengguna.
* `id` (INT, Primary Key, Auto Increment)
* `nama` (VARCHAR(150))
* `email` (VARCHAR(150), Unique)
* `password` (VARCHAR(255))
* `role_id` (INT, Foreign Key referencing `roles(id)`)
* `created_at` (TIMESTAMP)
* `updated_at` (TIMESTAMP)

#### 2.3 project_types
Master jenis kategori pekerjaan kreatif di agensi.
* `id` (INT, Primary Key, Auto Increment)
* `nama_proyek` (VARCHAR(100), Unique)

#### 2.4 ai_tools
Daftar alternatif AI Tools yang dinilai menggunakan metode TOPSIS.
* `id` (INT, Primary Key, Auto Increment)
* `nama_ai` (VARCHAR(100), Unique)
* `developer` (VARCHAR(100))
* `kategori` (VARCHAR(150))
* `website` (VARCHAR(255), Nullable)
* `deskripsi` (TEXT, Nullable)
* `status` (ENUM('aktif', 'nonaktif'))
* `created_at` (TIMESTAMP)
* `updated_at` (TIMESTAMP)

#### 2.5 criteria
Master kriteria penilaian TOPSIS.
* `id` (INT, Primary Key, Auto Increment)
* `kode` (VARCHAR(10), Unique)
* `nama_kriteria` (VARCHAR(150))
* `tipe` (ENUM('Benefit', 'Cost'))
* `deskripsi` (TEXT, Nullable)
* `created_at` (TIMESTAMP)
* `updated_at` (TIMESTAMP)

#### 2.6 criteria_weights
Bobot default skala kriteria dari Administrator.
* `id` (INT, Primary Key, Auto Increment)
* `criteria_id` (INT, Unique, Foreign Key referencing `criteria(id)`)
* `bobot` (TINYINT)
* `updated_at` (TIMESTAMP)

#### 2.7 matrix_values
Matriks keputusan global awal (Alternatif x Kriteria).
* `id` (INT, Primary Key, Auto Increment)
* `ai_id` (INT, Foreign Key referencing `ai_tools(id)`)
* `criteria_id` (INT, Foreign Key referencing `criteria(id)`)
* `nilai` (TINYINT)

#### 2.8 projects
Informasi proyek yang diinisialisasi oleh pengguna.
* `id` (INT, Primary Key, Auto Increment)
* `project_type_id` (INT, Foreign Key referencing `project_types(id)`)
* `nama_proyek` (VARCHAR(255))
* `deskripsi` (TEXT, Nullable)
* `created_at` (TIMESTAMP)
* `updated_at` (TIMESTAMP)

#### 2.9 assessments
Sesi evaluasi proyek.
* `id` (INT, Primary Key, Auto Increment)
* `project_id` (INT, Foreign Key referencing `projects(id)`)
* `tanggal_penilaian` (DATE)
* `created_at` (TIMESTAMP)

#### 2.10 assessment_details
Penyimpanan nilai bobot prioritas kriteria inputan user.
* `id` (INT, Primary Key, Auto Increment)
* `assessment_id` (INT, Foreign Key referencing `assessments(id)`)
* `criteria_id` (INT, Foreign Key referencing `criteria(id)`)
* `bobot` (TINYINT)

#### 2.11 topsis_results
Penyimpanan hasil akhir nilai preferensi ($C_i$) dan ranking alternatif.
* `id` (INT, Primary Key, Auto Increment)
* `assessment_id` (INT, Foreign Key referencing `assessments(id)`)
* `ai_id` (INT, Foreign Key referencing `ai_tools(id)`)
* `nilai_preferensi` (DECIMAL(10,8))
* `ranking` (INT)
* `created_at` (TIMESTAMP)

#### 2.12 calculation_logs
Penyimpanan salinan data JSON di setiap langkah matematis TOPSIS.
* `id` (INT, Primary Key, Auto Increment)
* `assessment_id` (INT, Foreign Key referencing `assessments(id)`)
* `tahap` (ENUM)
* `data_json` (LONGTEXT)
* `created_at` (TIMESTAMP)

#### 2.13 activity_logs
Pencatatan riwayat audit aktivitas sistem.
* `id` (INT, Primary Key, Auto Increment)
* `aktivitas` (VARCHAR(500))
* `created_at` (TIMESTAMP)

#### 2.14 statistics
Data agregasi performa dashboard.
* `id` (INT, Primary Key, Auto Increment)
* `nama_statistik` (VARCHAR(100), Unique)
* `nilai` (DECIMAL(15,2))
* `updated_at` (TIMESTAMP)

---

### 3. Integritas Relasional
Semua relasi antar-tabel menggunakan opsi:
* `ON UPDATE CASCADE`
* `ON DELETE CASCADE` (kecuali `users` ke `roles` dan `projects` ke `project_types` menggunakan `RESTRICT` untuk proteksi data penting).
