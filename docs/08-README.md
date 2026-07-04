# AInsight - SPK Pemilihan Perangkat AI (08-README.md)
## Notch Creative Agency Decision Support System using TOPSIS

AInsight adalah Sistem Pendukung Keputusan (SPK) untuk menentukan alternatif perangkat AI terbaik yang relevan untuk kebutuhan tim kreatif agensi Notch Creative Agency. Sistem ini dikembangkan dengan menggunakan framework **Laravel 12** dan metode **TOPSIS**.

---

### 1. Spesifikasi Tech Stack
* **Backend Framework:** Laravel 12
* **Language Runtime:** PHP 8.3+
* **Database Engine:** MySQL 8.0+ (InnoDB)
* **Frontend CSS Library:** Bootstrap 5 (Responsive)
* **Iconography:** Bootstrap Icons (v1.11)
* **Data Visualization:** Chart.js
* **Alert & Popups:** SweetAlert2

---

### 2. Struktur Proyek
Aplikasi mengikuti struktur arsitektur MVC bersih Laravel standar dengan penambahan berkas khusus:
* **`app/Services/TopsisService.php`:** Tempat penyimpanan utama algoritma perhitungan TOPSIS.
* **`app/Http/Requests/`:** Kelas penampung validasi request data form.
* **`resources/views/layouts/app.blade.php`:** Master template dashboard sidebar agensi.

---

### 3. Panduan Instalasi & Setup Lokal

#### Prasyarat Sistem
* XAMPP (dengan PHP 8.3+ aktif dan modul MySQL)
* Composer (Package Manager PHP)

#### Langkah 1: Kloning Proyek
Letakkan folder proyek di dalam directory server web Anda (misalnya `C:\xampp\htdocs\AInsight`).

#### Langkah 2: Konfigurasi Environment File
Salin berkas `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka berkas `.env` dan atur detail database MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ainsight_db
DB_USERNAME=root
DB_PASSWORD=
```

#### Langkah 3: Instalasi Dependensi Composer
Jalankan instalasi pustaka php pendukung:
```bash
composer install
```

#### Langkah 4: Generate Application Key
```bash
php artisan key:generate
```

#### Langkah 5: Migrasi Database & Seeding Data Awal
Pastikan server MySQL XAMPP Anda aktif, lalu jalankan perintah:
```bash
php artisan migrate --seed
```
*Perintah ini akan membuat semua struktur tabel dan mengisi data default 13 alternatif AI, 10 kriteria, bobot, dan akun Admin.*

#### Langkah 6: Jalankan Server Penguji
```bash
php artisan serve
```
Buka browser dan buka alamat `http://127.0.0.1:8000`.

---

### 4. Akun Login Default
* **Role Admin:** `admin@notchcreative.com` / password: `password`
* **Role User:** `user@notchcreative.com` / password: `password`

---

### 5. Dokumentasi Utama (Single Source of Truth)
Seluruh referensi dokumentasi pendukung proyek dapat dibaca di folder `docs/`:
1. [01-PRD.md](file:///c:/xampp/htdocs/AInsight/docs/01-PRD.md) - Product Requirements Document
2. [02-Technical-Architecture.md](file:///c:/xampp/htdocs/AInsight/docs/02-Technical-Architecture.md) - Blueprint Arsitektur Teknis
3. [03-AI-Skills.md](file:///c:/xampp/htdocs/AInsight/docs/03-AI-Skills.md) - Aturan Coding AI Developer
4. [04-Development-Plan.md](file:///c:/xampp/htdocs/AInsight/docs/04-Development-Plan.md) - Roadmap Sprint Pengembangan
5. [05-UI-Design-System.md](file:///c:/xampp/htdocs/AInsight/docs/05-UI-Design-System.md) - Standar UI & Palet Warna
6. [06-Business-Rules.md](file:///c:/xampp/htdocs/AInsight/docs/06-Business-Rules.md) - Perumusan TOPSIS & Logika Bisnis
7. [07-Database.md](file:///c:/xampp/htdocs/AInsight/docs/07-Database.md) - Detail Relasi & Skema Database
8. [08-README.md](file:///c:/xampp/htdocs/AInsight/docs/08-README.md) - Panduan Mulai Cepat
