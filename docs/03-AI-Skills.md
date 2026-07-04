# Development Rules & Coding Standard — AInsight (Laravel 12)

Dokumen ini merupakan standar baku dan aturan permanen yang wajib diikuti oleh seluruh pengembang (termasuk agen AI) dalam menulis kode untuk aplikasi **AInsight**.

---

## 1. General Rules
* **Framework:** Wajib menggunakan **Laravel 12**.
* **Minimum PHP Version:** **PHP 8.3** atau versi terbaru.
* **Database Engine:** **MySQL** (menggunakan InnoDB).
* **Frontend Tech Stack:** 
  * **Blade Template Engine** (tidak diperkenankan menggunakan Inertia, React, Vue, Svelte, atau Livewire).
  * **Bootstrap 5** (untuk layout responsif dan styling UI).
  * **Bootstrap Icons** (untuk kebutuhan ikonografi).
  * **Chart.js** (untuk kebutuhan visualisasi grafik statistik).
  * **SweetAlert2** (untuk notifikasi pop-up dan konfirmasi aksi).
* **Software Design Pattern:** 
  * Menerapkan pola **MVC (Model-View-Controller)**.
  * Menerapkan **Clean Architecture** dengan memisahkan logika bisnis dari HTTP controller menggunakan **Service Layer**.
  * Wajib menggunakan **Named Routes** di seluruh file routing (`routes/web.php`) dan view Blade.
  * Menggunakan **Form Request Validation** untuk seluruh penanganan input formulir.

---

## 2. Database & Eloquent Conventions
* **Table Naming:** Menggunakan format **snake_case** plural (jamak) sesuai dengan konvensi bawaan Laravel (contoh: `ai_tools`, `project_types`, `criteria_weights`).
* **Model Naming:** Menggunakan format **PascalCase** singular (tunggal) (contoh: `AITool`, `ProjectType`, `Criterion`).
* **Integritas Relasional:** Seluruh relasi antar-tabel wajib dideklarasikan secara fisik menggunakan **Foreign Keys** pada berkas migrasi database dengan opsi cascade (`ON UPDATE CASCADE` dan `ON DELETE CASCADE / RESTRICT` sesuai kebutuhan bisnis).
* **Migrations & Seeders:** Skema database harus dapat diduplikasi sepenuhnya menggunakan perintah `php artisan migrate --seed`. Seluruh master data wajib disertakan di dalam Seeder.
* **Soft Deletes:** Diimplementasikan hanya pada tabel yang membutuhkan retensi data histori jika dihapus oleh pengguna.

---

## 3. Controller Guidelines
* **Thin Controller:** Controller hanya bertanggung jawab menerima HTTP request, memvalidasi input via Form Request, mendelegasikan pemrosesan ke Service Layer, dan mengembalikan HTTP response (View atau Redirect).
* **Zero Database Query:** Dilarang keras menulis query SQL mentah (*raw queries*), query builder, maupun pemanggilan query Eloquent yang kompleks di dalam Controller.
* **Resource Controller:** Utamakan penggunaan *Resource Controller* untuk operasi CRUD standar.

---

## 4. Service Layer Guidelines (TOPSIS Engine)
* Seluruh operasi logika bisnis yang rumit wajib dipindahkan ke kelas Service di dalam folder `app/Services/`.
* Khusus metode TOPSIS, semua kalkulasi matematika wajib diisolasi di dalam kelas `app/Services/TopsisService.php`.
* Proses perhitungan TOPSIS di dalam Service wajib dipisahkan ke dalam metode-metode private yang terstruktur secara berurutan:
  1. `loadMatrixData()`: Memuat data matriks keputusan dari database.
  2. `normalize()`: Tahap Normalisasi Matriks.
  3. `applyWeights()`: Tahap Pembobotan Matriks Ternormalisasi.
  4. `findIdealSolutions()`: Penentuan Solusi Ideal Positif & Negatif.
  5. `calculateDistances()`: Perhitungan Jarak Solusi (Separation Measure).
  6. `calculatePreferences()`: Perhitungan Nilai Preferensi ($C_i$).
  7. `rank()`: Pengurutan Alternatif berdasarkan nilai preferensi tertinggi.

---

## 5. View & UI Consistency
* **Template Engine:** Wajib menggunakan file berekstensi `.blade.php`.
* **CSS Framework:** Wajib memanfaatkan layout bawaan **Bootstrap 5** dan bersifat responsif (Mobile Friendly).
* **Konsistensi Desain:** 
  * Jangan mengubah layout utama dashboard (sidebar & topbar) yang sudah ada.
  * Gunakan palet warna profesional bertema korporat kreatif dengan dominasi warna: **Putih (White)**, **Biru (Primary Blue)**, dan **Abu-abu Muda (Light Gray)**.
* **Keamanan Output:** Gunakan kurung kurawal ganda `{{ ... }}` untuk rendering data dari database guna mencegah celah keamanan Cross-Site Scripting (XSS).

---

## 6. Coding Standards
* **PSR-12 Compliance:** Penulisan kode PHP harus mematuhi standar penulisan **PSR-12 Extended Coding Style Guide**.
* **Type Hinting & Return Types:** Setiap deklarasi fungsi/metode wajib menggunakan pengetikan parameter yang jelas (*Type Hinting*) dan mendefinisikan tipe data nilai kembalian (*Return Type*) (contoh: `public function getById(int $id): ?AITool`).
* **Dependency Injection (DI):** Gunakan teknik DI pada constructor controller untuk memanggil Service Layer.
* **Eloquent Eager Loading:** Selalu gunakan eager loading (`with()`) saat memuat data relasi guna mencegah kendala performa *N+1 Query*.
* **Collections:** Manfaatkan fitur Laravel Collection untuk manipulasi array data.

---

## 7. Security Best Practices
* **CSRF Protection:** Form POST wajib menyertakan direktif `@csrf`.
* **SQL Injection Prevention:** Seluruh query database wajib menggunakan parameter pengikat (*parameter binding*) bawaan Eloquent atau PDO.
* **Mass Assignment Protection:** Seluruh Eloquent Model wajib mendefinisikan atribut `$fillable` secara ketat.

---

## 8. Larangan Keras (Prohibitions)
1. **Dilarang keras membuat halaman tiruan (Dummy Page) atau konten Placeholder.** Seluruh data wajib ditarik secara dinamis dari database menggunakan model.
2. **Dilarang menggunakan fungsi `echo`, `print_r`, atau `var_dump` di lingkungan produksi.** Gunakan helper Laravel `dd()` atau `dump()` hanya saat proses debugging lokal.
3. **Dilarang menuliskan query database di dalam file View Blade.**
4. **Dilarang keras melakukan hardcode data** untuk nilai alternatif AI, kriteria, bobot, atau data transaksi lainnya.
5. **Dilarang menulis kode atau fungsi mati** yang tidak digunakan di dalam aplikasi.
6. **Dilarang mengubah skema dan struktur tabel database** tanpa melalui berkas Laravel Migrations.
7. **Dilarang membuat fitur di luar cakupan dokumen PRD.**
