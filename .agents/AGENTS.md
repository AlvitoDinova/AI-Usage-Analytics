# Project Constitution
* **Project Name:** AInsight
* **Framework:** Laravel 12
* **Language:** PHP 8.3+
* **Database:** MySQL
* **Frontend:** Blade, Bootstrap 5, Chart.js, SweetAlert2
* **Architecture:** MVC, Service Layer, Repository Pattern (jika diperlukan)

---

# Source of Truth
Seluruh pengembangan **WAJIB** mengikuti dokumen-dokumen utama berikut sebagai acuan tunggal implementasi:
1. [01-PRD.md](file:///c:/xampp/htdocs/AInsight/docs/01-PRD.md) — Product Requirements Document
2. [02-Technical-Architecture.md](file:///c:/xampp/htdocs/AInsight/docs/02-Technical-Architecture.md) — Blueprint Arsitektur Teknis
3. [03-AI-Skills.md](file:///c:/xampp/htdocs/AInsight/docs/03-AI-Skills.md) — Aturan Pengkodean AI Developer
4. [04-Development-Plan.md](file:///c:/xampp/htdocs/AInsight/docs/04-Development-Plan.md) — Roadmap Sprint Pengembangan
5. [05-UI-Design-System.md](file:///c:/xampp/htdocs/AInsight/docs/05-UI-Design-System.md) — Panduan Visual & Desain UI
6. [06-Business-Rules.md](file:///c:/xampp/htdocs/AInsight/docs/06-Business-Rules.md) — Aturan Perhitungan TOPSIS & Validasi Bisnis
7. [07-Database.md](file:///c:/xampp/htdocs/AInsight/docs/07-Database.md) — Diagram Hubungan & Skema Database
8. [08-README.md](file:///c:/xampp/htdocs/AInsight/docs/08-README.md) — Panduan Memulai Cepat (Quickstart)

*Dokumen lain di luar daftar di atas (yang terletak di folder `docs/archive/`) adalah arsip dan **tidak boleh** digunakan sebagai acuan pengembangan.*

---

# Development Rules
* Seluruh kode harus dibangun di atas **Laravel 12** dan menggunakan **PHP 8.3+**.
* Desain halaman web wajib responsif menggunakan **Bootstrap 5** dan **Blade Template Engine**.
* Mengelola perubahan skema database menggunakan **Laravel Migrations** dan data awal menggunakan **Laravel Seeders**.
* Operasi database wajib memanfaatkan **Eloquent ORM** (hindari penulisan SQL mentah jika tidak mendesak).
* Validasi input dari pengguna wajib ditarik ke dalam kelas **Form Request Validation** kustom.
* Seluruh operasi logika bisnis yang rumit dipisahkan dari controller ke dalam **Service Layer**.
* Menggunakan **Named Routes** di seluruh rute dan view.
* Utamakan penggunaan **Resource Controller** untuk operasi CRUD standar.
* Seluruh penulisan kode harus mematuhi standar penulisan kode PHP **PSR-12**.
* Gunakan **Dependency Injection** pada konstruktor controller untuk memanggil Service.

---

# Forbidden
* **Dilarang keras membuat elemen penahan tempat (Placeholder), Dummy Page, Mock Page, atau teks Coming Soon.** Seluruh antarmuka harus langsung terhubung ke database.
* Dilarang keras melakukan hardcode data untuk nilai kriteria, alternatif AI, maupun data transaksi lainnya.
* Dilarang keras menulis query SQL atau memanggil model database di dalam View Blade.
* Dilarang keras menuliskan logika bisnis atau komputasi matematika TOPSIS di dalam Controller.
* Jangan mengubah antarmuka UI utama dashboard (sidebar & topbar) tanpa persetujuan tim.
* Jangan mengubah skema database secara langsung tanpa membuat file Laravel Migrations baru.

---

# Development Workflow
Seluruh pengerjaan aplikasi wajib mengikuti urutan implementasi Sprint berikut secara bertahap:
1. **Sprint 0: Project Initialization** (Konfigurasi Laravel, Layout dashboard, Migrasi database, Seeders)
2. **Sprint 1: Authentication & User Management** (Login, logout, Middleware hak akses, profil)
3. **Sprint 2: Master Data Management** (CRUD AI Tools, Kriteria, dan Jenis Proyek)
4. **Sprint 3: Project Assessment Setup** (Form inisialisasi proyek dan input bobot dinamis)
5. **Sprint 4: Decision Matrix Grid** (Tabel silang edit nilai kinerja Alternatif x Kriteria)
6. **Sprint 5: TOPSIS Service Engine** (Algoritma matematika TOPSIS pada `TopsisService.php` + Unit Test)
7. **Sprint 6: Recommendation Result & Export** (Tampilan peringkat preferensi dan ekspor laporan PDF/Excel)
8. **Sprint 7: Interactive Dashboard** (Query statistik visual Chart.js pada dashboard agensi)
9. **Sprint 8: System Polishing & UI Optimization** (Halaman error kustom, pemuatan state, SweetAlert2)
10. **Sprint 11: QA & Security Testing** (Pengujian Black-box, perbaikan bug, audit Lighthouse)
11. **Sprint 10: Deployment Preparation** (Optimasi cache server produksi, file README & Buku Manual)

---

# Coding Philosophy
* **Kualitas di Atas Kecepatan:** Selalu memprioritaskan penulisan kode yang bersih, mudah dipelihara, dan memiliki performa yang baik.
* **Zero Dead Code:** Bersihkan semua fungsi, variabel, atau baris komentar pengujian yang tidak lagi digunakan sebelum melakukan commit.
* **DRY (Don't Repeat Yourself):** Hindari logika duplikat dengan memanfaatkan abstraksi fungsi pembantu atau Service Helper.
* **Production Ready:** Setiap modul yang diselesaikan harus dalam kondisi stabil dan siap digunakan oleh pengguna agensi.
