# Master Development Plan (MDP)
## Sistem Pendukung Keputusan Pemilihan Penggunaan AI pada Industri Kreatif di Notch Creative Agency Menggunakan Metode TOPSIS (AInsight)

---

### 1. Rekomendasi Urutan Implementasi Terbaik
Untuk menghindari pembuatan halaman tiruan (*dummy page*) atau elemen penahan tempat (*placeholder*) di dalam aplikasi AInsight selama proses pengembangan, pengembang wajib mengikuti strategi pembangunan bertahap (incremental development) yang teratur:
1. **Urutan Dependensi:** Selesaikan rancangan database dan struktur layout dasar terlebih dahulu (Sprint 0), dilanjutkan dengan pengamanan sistem (Sprint 1). 
2. **Pengisian Master Data Sebelum Transaksi:** Selesaikan modul CRUD data dasar alternatif AI dan Kriteria (Sprint 2) sebelum beralih ke pembuatan Matriks Keputusan global (Sprint 4) dan Penilaian Proyek (Sprint 3). Hal ini menjamin formulir transaksi selalu menarik data real-time yang valid dari database.
3. **Pemisahan Perhitungan TOPSIS:** Pembangunan kelas `TopsisService` (Sprint 5) harus diuji secara menyeluruh melalui Unit Testing sebelum diintegrasikan secara visual ke halaman Hasil Rekomendasi (Sprint 6).
4. **Dashboard Sebagai Muara Data:** Modul Dashboard (Sprint 7) diselesaikan paling akhir setelah semua modul transaksi berfungsi penuh agar widget dashboard dapat melakukan agregasi data nyata dari tabel transaksi yang sudah terisi.

---

### 2. Definition of Ready (DoR) & Definition of Done (DoD) Umum

#### Definition of Ready (DoR)
* Kebutuhan fungsional di dalam PRD sudah jelas dan tidak ambigu.
* Skema database terkait sudah dirancang, dimigrasikan, dan diverifikasi relasinya.
* Dependensi Sprint sebelumnya telah berstatus "Done".
* Desain antarmuka Blade layout pendukung telah tersedia.

#### Definition of Done (DoD)
* Kode program bebas dari syntax error dan mematuhi aturan standar penulisan PSR-12.
* Form input dilengkapi validasi Form Request (bukan validasi controller).
* Data ditarik secara dinamis dari database menggunakan Eloquent (tidak ada hardcode data).
* Halaman responsif dan teruji bebas dari elemen *placeholder* atau teks dummy.
* Kode telah lolos verifikasi peninjauan (*code review*).

---

### 3. Sprint Roadmap

#### Sprint 0: Project Initialization
* **Tujuan Sprint:** Menyiapkan fondasi framework, konfigurasi dasar, skema database, dan arsitektur visual utama aplikasi.
* **Modul:** Project Setup & Core Layout.
* **Daftar Pekerjaan:** Setup Laravel, konfigurasi `.env`, setup database, migration, seeder master data awal, layout sidebar/navbar.
* **Deliverables:** Repositori Git aktif dengan setup database awal.
* **Acceptance Criteria:** `php artisan migrate --seed` berjalan sukses.
* **Complexity:** 2/5.
* **Dependency:** None.

#### Sprint 1: Authentication & User Management
* **Tujuan Sprint:** Mengamankan akses aplikasi dan membagi hak akses menu berdasarkan peran pengguna.
* **Modul:** Auth & Profile.
* **Daftar Pekerjaan:** LoginController, RegisterController, Blade template auth, Auth/Admin middlewares, Edit Profile.
* **Deliverables:** Form auth fungsional dengan session.
* **Acceptance Criteria:** Rute `/dashboard` menolak user tamu.
* **Complexity:** 3/5.
* **Dependency:** Sprint 0.

#### Sprint 2: Master Data Management
* **Tujuan Sprint:** Membangun antarmuka CRUD lengkap untuk mengelola entitas master pendukung evaluasi TOPSIS.
* **Modul:** AI Management, Criteria Management, Criteria Weight, Project Types.
* **Daftar Pekerjaan:** Resource Controller & Form request validation, search, pagination, dynamic relational database load.
* **Deliverables:** Halaman CRUD AI, Kriteria, dan Jenis Proyek.
* **Acceptance Criteria:** Administrator bisa menambah/mengubah data.
* **Complexity:** 3/5.
* **Dependency:** Sprint 1.

#### Sprint 3: Project Assessment Setup
* **Tujuan Sprint:** Menyediakan antarmuka bagi tim kreatif untuk menginput proyek baru dan menentukan bobot prioritas kriteria.
* **Modul:** Project Assessment.
* **Daftar Pekerjaan:** Form projects, input slider rating 1-5 untuk 10 kriteria evaluasi, menyimpan ke database.
* **Deliverables:** Form input proyek baru dan detail prioritas kriteria.
* **Acceptance Criteria:** Data tersimpan pada tabel assessments dan assessment_details.
* **Complexity:** 4/5.
* **Dependency:** Sprint 2.

#### Sprint 4: Decision Matrix Grid
* **Tujuan Sprint:** Mengelola nilai kinerja alternatif AI terhadap masing-masing kriteria.
* **Modul:** Decision Matrix.
* **Daftar Pekerjaan:** Halaman tabel silang (AI x Kriteria), matrix grid update, batch update transaction.
* **Deliverables:** Grid update matriks keputusan global.
* **Acceptance Criteria:** 130 kombinasi nilai (13 AI x 10 Kriteria) terisi lengkap.
* **Complexity:** 4/5.
* **Dependency:** Sprint 2.

#### Sprint 5: TOPSIS Service Engine
* **Tujuan Sprint:** Membangun dan menguji kebenaran algoritma perhitungan matematis metode TOPSIS di backend.
* **Modul:** TOPSIS Engine (`TopsisService`).
* **Daftar Pekerjaan:** File `TopsisService.php`, normalisasi, pembobotan, solusi ideal, jarak solusi, preferensi, unit test matematika, logging JSON.
* **Deliverables:** Service kalkulasi TOPSIS andal dengan unit test.
* **Acceptance Criteria:** Nilai preferensi akhir $C_i$ berada di rentang 0-1, unit test lolos.
* **Complexity:** 5/5.
* **Dependency:** Sprint 3 & Sprint 4.

#### Sprint 6: Recommendation Result & Export
* **Tujuan Sprint:** Menampilkan hasil akhir peringkat alternatif AI dan memfasilitasi ekspor laporan.
* **Modul:** Recommendation & Reporting.
* **Daftar Pekerjaan:** Halaman ranking descending, visualisasi accordion perhitungan, integrasi DomPDF, integrasi Laravel Excel.
* **Deliverables:** View ranking dan tombol ekspor.
* **Acceptance Criteria:** PDF dan Excel terunduh dengan rapi.
* **Complexity:** 3/5.
* **Dependency:** Sprint 5.

#### Sprint 7: Interactive Dashboard
* **Tujuan Sprint:** Menyajikan pusat informasi ringkasan data agensi secara visual dan dinamis.
* **Modul:** Dashboard.
* **Daftar Pekerjaan:** Query total, Chart.js integrasi (doughnut & bar), tabel riwayat proyek terbaru.
* **Deliverables:** Halaman dashboard interaktif.
* **Acceptance Criteria:** Halaman termuat di bawah 1 detik dengan data nyata.
* **Complexity:** 3/5.
* **Dependency:** Sprint 6.

#### Sprint 8: System Polishing & UI Optimization
* **Tujuan Sprint:** Meningkatkan pengalaman pengguna, merapikan antarmuka, dan menangani error sistem secara elegan.
* **Modul:** Polishing.
* **Daftar Pekerjaan:** Halaman error 404/500, loading states, empty states, responsivitas Bootstrap, SweetAlert2 alerts.
* **Complexity:** 3/5.
* **Dependency:** Sprint 7.

#### Sprint 9: QA & Security Testing
* **Tujuan Sprint:** Melakukan verifikasi dan validasi fungsionalitas, performa, serta celah keamanan aplikasi secara menyeluruh.
* **Modul:** Quality Assurance.
* **Daftar Pekerjaan:** Black-box testing CRUD, SQL injection check, XSS check, Lighthouse audit.
* **Complexity:** 3/5.
* **Dependency:** Sprint 8.

#### Sprint 10: Deployment Preparation
* **Tujuan Sprint:** Menyiapkan lingkungan produksi agensi dan mendokumentasikan panduan operasional aplikasi.
* **Modul:** Release & Documentation.
* **Daftar Pekerjaan:** Setup server lokal, config:cache, db backup, README.md, user manual.
* **Complexity:** 3/5.
* **Dependency:** Sprint 9.

---

### 4. Project Timeline & Milestone
* **Bulan 1:** Setup database & layouts, Auth, CRUD master data AI/Kriteria/Proyek.
* **Bulan 2:** Penilaian Proyek, implementasi TOPSIS Service, Hasil Ranking & Ekspor.
* **Bulan 3:** Dashboard Chart.js, Polishing UI & SweetAlert2, QA Audit, Deployment agensi.

---

### 5. Risk Management
* **R-01 (Kalkulasi Salah):** Diatasi dengan Unit Testing matematika membandingkan hasil manual.
* **R-02 (Kehilangan Data):** Diatasi dengan foreign keys CASCADE dan backup database terjadwal.
* **R-03 (Layout Mobile Pecah):** Diatasi dengan responsive utility Bootstrap 5.

---

### 6. Git Branch Strategy
* Cabang `main` (produksi stabil), `develop` (integrasi fitur), dan `feature/` (pengembangan fitur individual per-sprint).

---

### 7. Code Review Checklist
* Bebas dari raw SQL queries.
* Input dilindungi kelas Form Request.
* Variabel Blade dilindungi HTML escaping `{{ }}`.

---

### 8. Testing Checklist
* Jalankan `php artisan test` untuk verifikasi TOPSIS.
* Uji coba validasi input form dengan data kosong/salah.
