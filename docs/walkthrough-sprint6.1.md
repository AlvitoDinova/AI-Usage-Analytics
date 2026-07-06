# Walkthrough Sprint 6.1 — UI & UX Polishing (Safe Patch)
## AInsight — Sistem Pendukung Keputusan Pemilihan AI

Dokumen ini menjelaskan berkas yang diubah, bug yang diperbaiki, hasil pengujian regresi, dan ringkasan Sprint 6.1. Pengubahan ini murni pada UI/UX dan controller tanpa mengubah skema database, seeder, maupun data yang ada.

---

### 1. Bug & Masalah yang Diperbaiki

#### A. Login Validation & Error Messages (Target 1 & 2)
- **Masalah:** Validasi email atau password kosong sebelumnya memicu tooltip bawaan browser (HTML5) "Please fill out this field.". Ketika kredensial salah, pesan error terikat di bawah kolom email, sehingga kurang intuitif.
- **Solusi:**
  1. Menghilangkan atribut `required` pada input email dan password di `login.blade.php` untuk menonaktifkan validasi HTML5.
  2. Mengandalkan validasi Laravel sepenuhnya dengan output pesan Bahasa Indonesia: "Email wajib diisi." dan "Password wajib diisi.".
  3. Ketika password atau email salah, `LoginController` akan mengalihkan kembali dengan flash alert: `"Email atau Password yang Anda masukkan tidak sesuai."`. Pesan ini ditampilkan sebagai alert Bootstrap merah di atas form, terpisah dari input field.

#### B. Redesign Login Page (Target 3)
- **Masalah:** Halaman login sebelumnya bertema gelap (Dark Theme) sehingga tidak konsisten dengan visual utama aplikasi AInsight yang didominasi warna terang-biru.
- **Solusi:**
  - Mengubah latar belakang menjadi gradasi biru muda yang elegan (`linear-gradient`).
  - Menggunakan card login berwarna putih bersih dengan bayangan lembut (`shadow`).
  - Menampilkan Logo AInsight, Judul `"AInsight - Decision Support System"`, dan Subtitle `"Sistem Pendukung Keputusan Pemilihan Artificial Intelligence menggunakan metode TOPSIS"`.
  - Mengubah tombol login menggunakan warna biru korporat (`#2563eb`).

#### C. Project Owner Column (Target 4)
- **Masalah:** Admin dan Manager sebelumnya tidak dapat langsung mengidentifikasi siapa pemilik/pembuat proyek di tabel daftar proyek.
- **Solusi:**
  - Menambahkan eager loading `owner` pada `ProjectController@index` untuk optimasi kueri.
  - Menambahkan kolom baru `"Pemilik Project"` pada tabel Penilaian Proyek di `index.blade.php` proyek. Kolom ini hanya dirender jika role pengguna saat ini adalah `admin` atau `manager` (tidak terlihat pada Employee).

#### D. Responsive Statistik SPK (Target 5)
- **Masalah:** Elemen widget/card Statistik SPK bertabrakan atau angkanya terpotong/squeezed pada ukuran viewport laptop kecil atau tablet.
- **Solusi:**
  - Menyusun ulang kelas Bootstrap Grid agar lebih adaptif:
    - Card KPI utama menggunakan `col-12 col-sm-6 col-xl-3` (menumpuk di mobile, membagi 2 kolom di tablet/laptop kecil, dan 4 kolom di layar besar).
    - Card grafik/tabel menggunakan `col-12 col-xl-6` agar bertumpuk secara elegan pada laptop kecil daripada terkompresi.
    - Grid distribusi kategori menggunakan `col-12 col-sm-6 col-lg-4 col-xl-3` untuk memberi ruang baca teks yang optimal.

---

### 2. Berkas yang Diubah (Modified Files)

1. [LoginController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/Auth/LoginController.php) — Memperbarui penanganan kegagalan kredensial dan pesan kosong "Password wajib diisi.".
2. [ProjectController.php](file:///c:/xampp/htdocs/AInsight/app/Http/Controllers/ProjectController.php) — Eager load relasi `owner` pada index proyek.
3. [login.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/auth/login.blade.php) — Redesain tema terang modern enterprise login dan penyesuaian validasi.
4. [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/index.blade.php) — Menambahkan kolom pemilik proyek untuk Admin & Manager.
5. [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/statistics/index.blade.php) — Optimalisasi grid responsif untuk Statistik SPK.
6. [RbacTest.php](file:///c:/xampp/htdocs/AInsight/tests/Feature/RbacTest.php) — Menyesuaikan asersi kegagalan login dengan format flash alert.

---

### 3. Hasil Pengujian Regresi
Pengujian unit dan fungsionalitas aplikasi berhasil diselesaikan dengan sukses 100%:

```
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Unit\TopsisIdenticalValuesTest
  ✓ topsis calculation with identical alternatives gracefully falls back to 0 5                                  0.40s  

   PASS  Tests\Unit\TopsisInvalidationTest
  ✓ topsis results are deleted and status resets to draft when ai list changes                                   0.09s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                                                                0.04s  

   PASS  Tests\Feature\RbacTest
  ✓ unauthenticated users are redirected to login                                                                0.02s  
  ✓ users can login with correct credentials                                                                     0.03s  
  ✓ users cannot login with incorrect credentials                                                                0.23s  
  ✓ inactive users cannot login                                                                                  0.05s  
  ✓ admin can access user management and master data                                                             0.03s  
  ✓ manager cannot access user management or master data                                                         0.03s  
  ✓ employee can only see their own projects and history                                                         0.04s  

  Tests:    11 passed (42 assertions)
  Duration: 1.21s
```

Fungsionalitas inti (Login, RBAC, Matrix, TOPSIS, History, PDF, Logs) berjalan dengan stabil, cepat, dan aman.
