# Technical Architecture Document (TAD)
## Sistem Pendukung Keputusan Pemilihan Penggunaan AI pada Industri Kreatif di Notch Creative Agency Menggunakan Metode TOPSIS (AInsight)

---

### 1. Arsitektur Sistem
AInsight menggunakan arsitektur **Three-Tier Architecture** yang memisahkan tanggung jawab sistem menjadi tiga lapisan utama:
1. **Presentation Layer:** Menggunakan HTML5, CSS3, dan **Bootstrap 5** sebagai framework CSS, serta **Chart.js** untuk rendering visualisasi statistik di sisi klien. Rendering halaman ditangani langsung oleh server menggunakan Laravel Blade Templating Engine.
2. **Application Layer:** Menggunakan **Laravel 12** yang berjalan di atas **PHP 8.3+**. Logika bisnis, routing, validasi, otorisasi, dan kalkulasi metode TOPSIS diimplementasikan di lapisan ini.
3. **Database Layer:** Menggunakan **MySQL** sebagai RDBMS untuk menyimpan data pengguna, alternatif AI, kriteria, matriks keputusan, serta log transaksi perhitungan.

---

### 2. High-Level Architecture
* **Client Browser:** Berinteraksi via HTTP request dan menerima rendering Blade yang kaya komponen Bootstrap 5.
* **Laravel Web Application Layer:** Melakukan routing permintaan, memproses middleware otentikasi, menjalankan logika bisnis di Service Layer, dan berinteraksi dengan database via Eloquent ORM.
* **MySQL Database:** Menyimpan data terstruktur InnoDB dengan relasi kunci asing (Foreign Keys) berproteksi cascade.

---

### 3. Folder Structure Laravel
Rekomendasi struktur direktori terbaik untuk proyek Laravel 12 AInsight adalah sebagai berikut:
```
ainsight/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AIController.php
│   │   │   ├── CriteriaController.php
│   │   │   ├── ProjectController.php
│   │   │   └── DashboardController.php
│   │   └── Requests/
│   │       ├── StoreAIRequest.php
│   │       └── StoreCriteriaRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── AITool.php
│   │   ├── Criterion.php
│   │   ├── Project.php
│   │   ├── Assessment.php
│   │   └── TopsisResult.php
│   └── Services/
│       └── TopsisService.php          # Service khusus kalkulasi matematika TOPSIS
├── database/
│   ├── migrations/                    # File skema database Laravel Migrations
│   └── seeders/                       # File pengisian data awal otomatis (Seeder)
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php          # Master layout dashboard
│       ├── admin/
│       │   ├── ai/                    # View CRUD Alternatif AI
│       │   └── criteria/              # View CRUD Kriteria
│       └── user/
│           ├── dashboard.blade.php    # Dashboard utama
│           └── assess/                # View Form Evaluasi Proyek
└── routes/
    └── web.php                        # Seluruh rute aplikasi (MVC web)
```

---

### 4. MVC Pattern
* **Model:** Menangani hubungan dengan database menggunakan Eloquent ORM.
* **View:** Menggunakan berkas berekstensi `.blade.php` untuk menampilkan UI berbasis HTML dan CSS.
* **Controller:** Mengatur jalannya request/response, memanggil kelas validasi kustom, serta mendelegasikan tugas ke kelas Service.

---

### 5. Route Structure
* Rute dilindungi oleh middleware `auth` untuk membatasi akses tim agensi.
* Rute master data di folder `/admin/*` dilindungi middleware kustom `admin` agar hanya dapat diakses oleh Administrator.

---

### 6. Controller Design
Menerapkan prinsip **Single Responsibility Principle (SRP)**. Controller didesain sangat tipis (*Thin Controller*). Logika validasi dipindahkan ke *Form Request*, sedangkan pemrosesan matematika TOPSIS dipindahkan ke *Service Layer*.

---

### 7. Model Design
Setiap model memiliki representasi di database dan mendefinisikan array `$fillable` secara ketat untuk menangkal ancaman *mass assignment*.

---

### 8. Service Layer Design
Seluruh logika matematika TOPSIS dipisahkan ke kelas `TopsisService` (`app/Services/TopsisService.php`). Controller hanya bertugas memanggil service ini dan menerima output preferensi yang sudah terurut.

---

### 9. Repository Pattern
*Tidak diperlukan* untuk tahap awal proyek ini demi menghindari over-engineering. Penggunaan Eloquent ORM secara langsung di dalam Service Layer sudah cukup memadai untuk kebutuhan aplikasi AInsight.

---

### 10. Database Architecture
Sistem basis data dirancang untuk memenuhi kaidah **Third Normal Form (3NF)** guna menghindari redundansi data dan menjaga integritas referensial.
* Menggunakan mesin penyimpanan **InnoDB** dengan Charset: `utf8mb4_unicode_ci`.

---

### 11. Migration Strategy
Skema tabel dikelola sepenuhnya via Laravel Migrations sehingga penginstalan database dapat dilakukan hanya dengan perintah `php artisan migrate`.

---

### 12. Seeder Strategy
Pengisian otomatis data awal untuk role pengguna, akun administrator, jenis proyek, kriteria penilaian, dan 13 alternatif AI Tools awal lengkap dengan nilai matriks keputusan global default.

---

### 13. Relationship Diagram (Teks)
Setiap sesi penilaian proyek (`assessments`) terhubung ke `projects`, memiliki banyak baris bobot masukan user di `assessment_details`, log matematika di `calculation_logs`, dan hasil ranking akhir di `topsis_results`.

---

### 14. Authentication Flow
Sistem menggunakan modul otentikasi berbasis session bawaan Laravel untuk memverifikasi kredensial password pengguna menggunakan enkripsi bcrypt.

---

### 15. Authorization
Otorisasi membedakan hak akses berdasarkan kolom `role_id` pada model `User` menggunakan Laravel **Gate** atau **Middleware** kustom.

---

### 16. Validation Strategy
Setiap input dari formulir divalidasi dengan ketat menggunakan kelas **Form Request** Laravel, memisahkan logika validasi dari file controller utama.

---

### 17. Logging Strategy
AInsight mengonfigurasi log internal menggunakan pustaka **Monolog** bawaan Laravel, kesalahan sistem dicatat ke berkas `storage/logs/laravel.log`.

---

### 18. Exception Handling
Kesalahan pada sistem (seperti kegagalan database atau data tidak ditemukan) ditangkap menggunakan Handler global Laravel dan dialihkan ke halaman error ramah pengguna (halaman 404, 500).

---

### 19. File Upload Strategy
*Tidak diperlukan* untuk fungsionalitas dasar sistem rekomendasi. Jika dibutuhkan ikon untuk alternatif AI, berkas akan disimpan di dalam penyimpanan lokal Laravel (`storage/app/public/`) dan dihubungkan ke direktori publik menggunakan tautan simbolis (*symlink*).

---

### 20. Dashboard Architecture
Halaman Dashboard Admin dan User dipisahkan secara logis, data dashboard diambil lewat query agregasi langsung di database.

---

### 21. Statistics Architecture
Visualisasi grafik pada dashboard menggunakan pustaka **Chart.js** yang dirender di sisi client dengan membaca variabel JSON dari controller.

---

### 22. TOPSIS Service Architecture
Konsep struktur internal dari `TopsisService` dirancang memiliki metode-metode private yang mewakili setiap langkah matematika TOPSIS untuk memisahkan tahapan komputasi secara modular.

---

### 23. Calculation Flow
Perhitungan TOPSIS dipicu saat tim kreatif menyelesaikan pengisian bobot proyek, mengeksekusi perhitungan dari matriks keputusan dasar, dan menyimpan hasilnya.

---

### 24. Performance Optimization
* **Lazy Loading vs Eager Loading:** Menghindari masalah query berulang-ulang (*N+1 Query Problem*) dengan memanggil relasi database menggunakan metode `with()` bawaan Eloquent.
* **Database Indexing:** Kolom kunci asing (*Foreign Keys*) diindeks secara eksplisit.

---

### 25. Security Best Practice
* Perlindungan bawaan terhadap CSRF, SQL Injection (via parameter binding Eloquent/PDO), dan Cross-Site Scripting (XSS via escaping kurung kurawal ganda Blade).

---

### 26. Coding Convention
Aplikasi AInsight wajib mematuhi standar penulisan kode PHP global PSR-12, penamaan kelas CamelCase, dan type-hinting serta return type yang jelas untuk seluruh metode.
