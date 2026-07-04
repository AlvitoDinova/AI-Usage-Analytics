# UI Design System Document (UI-DSD)
## Sistem Pendukung Keputusan Pemilihan Penggunaan AI pada Industri Kreatif di Notch Creative Agency Menggunakan Metode TOPSIS (AInsight)

---

### 1. Design Philosophy
AInsight mengusung filosofi desain **Professional, Modern, Minimalist, Corporate, dan Clean**. Antarmuka dirancang untuk menyajikan data analitis secara terstruktur tanpa menimbulkan kebingungan visual (*cognitive overload*). Fokus utama adalah kejelasan alur informasi, keterbacaan angka metrik, dan navigasi yang efisien agar tim agensi kreatif dapat mengambil keputusan pemilihan AI dengan cepat dan tepat.

---

### 2. Branding
* **Nama Aplikasi:** AInsight (Keputusan Berbasis Data untuk Pemanfaatan AI).
* **Identitas Visual:** Minimalis dan berwibawa, menonjolkan kecerdasan buatan (AI) dan wawasan analitis (Insight).
* **Karakter Logo:** Tipografi sans-serif dengan ketebalan tebal (*bold*) pada bagian "Insight" dan warna biru royal yang memancarkan stabilitas teknologi serta profesionalisme agensi.

---

### 3. Color Palette
Sistem menerapkan palet warna bertema korporat modern yang ketat untuk menjaga konsistensi elemen visual:
* **Primary (Biru Royal):** `#2563EB` (Warna utama untuk tombol aksi, menu aktif, dan sorotan utama).
* **Secondary (Slate Off-White):** `#F8FAFC` (Warna pengisi latar belakang panel abu-abu sangat muda dan shading sekunder).
* **Background (Putih):** `#FFFFFF` (Warna latar belakang utama halaman, kontainer card, dan sel tabel).
* **Border (Abu-abu Terang):** `#E5E7EB` (Warna garis pembatas tipis untuk memisahkan grid kontainer).
* **Text (Slate Dark):** `#1E293B` (Warna tulisan utama untuk kontras pembacaan maksimal).
* **Text Muted (Slate Gray):** `#64748B` (Warna untuk teks penjelasan sekunder dan label pembantu).

---

### 4. Typography
* **Keluarga Font:** `Plus Jakarta Sans`, sans-serif (diambil secara dinamis dari Google Fonts).
* **Hierarki Font:**
  * **H1 (Judul Halaman):** `1.5rem` (24px) | Bold (`700`) | Warna: Text Dark.
  * **H2 (Judul Seksi/Modul):** `1.25rem` (20px) | Semi-Bold (`600`) | Warna: Text Dark.
  * **H3 (Judul Card/Tabel):** `0.9rem` (14px) | Extra Bold (`800`) | Warna: Text Muted (Uppercase).
  * **Body (Teks Utama/Form):** `0.85rem` (13.6px) | Regular (`400`) atau Medium (`500`) | Warna: Text Dark.
  * **Small (Keterangan/Meta):** `0.75rem` (12px) | Regular | Warna: Text Muted.

---

### 5. Grid System
AInsight menggunakan **12-Column Grid System** bawaan **Bootstrap 5**:
* Menggunakan kontainer fluid `.container` untuk halaman dashboard agar memanfaatkan area layar secara maksimal.
* Pembagian kolom fleksibel menggunakan kelas `.col-12` (mobile), `.col-md-6` (tablet), dan `.col-lg-3` atau `.col-lg-4` (desktop) untuk menjaga susunan grid tetap seimbang.

---

### 6. Layout
Tata letak utama menggunakan model **App Shell** yang terdiri dari dua area utama:
1. **Sidebar Navigation (Panel Kiri):** Tetap berada di sisi kiri layar dengan lebar `240px`.
2. **Main Content Workspace (Area Kanan):** Area dinamis untuk merender halaman modul SPK, dengan margin kiri otomatis `240px` untuk mengimbangi sidebar.

---

### 7. Sidebar
* **Warna Dasar:** `#FFFFFF` dengan batas kanan tipis `1px solid #E5E7EB`.
* **Lebar:** `240px` dengan penataan tinggi penuh (*height: 100vh*).
* **Menu Items:**
  * Ketinggian baris menu nyaman dengan ikon Bootstrap Icons di sebelah kiri teks.
  * **Item Aktif:** Latar belakang biru transparan (`rgba(37, 99, 235, 0.1)`), warna teks biru royal (`#2563EB`), dan ketebalan font Semi-Bold.
  * **Item Hover:** Latar belakang abu-abu sangat muda (`#F8FAFC`) dengan transisi halus 0.15 detik.

---

### 8. Navbar
* **Warna Dasar:** `#FFFFFF` dengan pembatas bawah tipis `1px solid #E5E7EB`.
* **Ketinggian:** Tetap `56px` dengan posisi *sticky* di bagian atas layar.
* **Konten Kanan:** Menampilkan identitas pengguna aktif (Developer/Admin) dan lencana penunjuk status pengembangan (`DEV MODE`) berwarna kuning transparan.

---

### 9. Dashboard
* Halaman utama dashboard dirancang bersih dengan menyembunyikan detail rumit.
* Area terbagi menjadi tiga seksi utama: Baris Widget Card Statistik di bagian atas, Bagan Alur Pipeline TOPSIS di bagian tengah, dan Grid Pintasan Menu Aksi di bagian bawah.

---

### 10. Card
* **Latar Belakang:** `#FFFFFF` dengan sudut melingkar (*border-radius: 12px*).
* **Bayangan (Shadow):** Menggunakan bayangan tipis modern (`box-shadow: 0 1px 3px rgba(0,0,0,0.05)`).
* **Hover State:** Bergerak naik secara mikro (`transform: translateY(-2px)`) dan bayangan sedikit menebal dengan transisi lembut 0.2 detik.

---

### 11. Statistic Card
* Card khusus untuk menampilkan metrik angka kuantitatif utama.
* **Komposisi:** Wadah ikon persegi dengan sudut melingkar di sebelah kiri (warna latar ikon transparan mengikuti aksen metrik), diikuti label metrik kecil dan angka nilai metrik berukuran besar (`1.65rem`) dengan ketebalan tebal.

---

### 12. Button
* **Button Primary:** Latar belakang `#2563EB`, warna teks `#FFFFFF`, dengan radius sudut `8px`.
* **Button Secondary/Outline:** Latar belakang `#FFFFFF` dengan batas luar tipis, warna teks slate dark.
* **Button Hover State:** Warna latar bergeser menjadi sedikit lebih gelap dengan transisi halus. Tombol dinonaktifkan (*disabled*) akan berubah warna menjadi abu-abu pudar tanpa efek pointer.

---

### 13. Form
* Setiap form dikelompokkan menggunakan kelas `.mb-3` untuk jarak vertikal yang konsisten.
* Label input diletakkan di atas kolom pengisian dengan ketebalan font Semi-Bold (`600`) dan warna sedikit lebih gelap.

---

### 14. Input
* Menggunakan kelas `.form-control` Bootstrap 5 dengan tinggi baris input yang nyaman.
* **Fokus Input (Focus State):** Warna garis pembatas berubah menjadi biru royal `#2563EB` dengan efek bayangan luar tipis (*box-shadow outline*) berwarna biru pudar untuk menegaskan area aktif.

---

### 15. Select
* Menggunakan kelas `.form-select` Bootstrap 5.
* Memiliki perilaku visual fokus dan sudut lengkungan yang identik dengan elemen input teks standar untuk menjaga konsistensi form.

---

### 16. Table
* Menggunakan kelas `.table` dan `.table-hover` Bootstrap 5.
* **Header Tabel:** Latar belakang `#F8FAFC` dengan warna teks Slate Gray, ditulis dalam format huruf besar (*uppercase*) untuk membedakan kolom data.
* **Baris Data:** Latar belakang putih dengan garis batas baris horisontal yang sangat tipis.

---

### 17. Badge
* Digunakan untuk label status (aktif/nonaktif, tipe benefit/cost).
* **Badge Aktif/Benefit:** Warna hijau transparan dengan teks hijau gelap.
* **Badge Nonaktif/Cost:** Warna merah transparan dengan teks merah gelap.
* **Sudut Lengkungan:** Membulat penuh (*pill badge*) untuk kemudahan pembedaan visual.

---

### 18. Alert
* Menggunakan komponen alert Bootstrap 5 dengan warna transparan yang lembut (tidak terlalu mencolok).
* Menyediakan tombol tutup (*dismissible button*) berbentuk tanda silang kecil di sisi kanan.

---

### 19. Modal
* Kotak dialog konfirmasi menggunakan sudut melingkar `12px` dengan bayangan tebal.
* Header modal memuat tombol tutup silang standar dan footer modal menyediakan dua aksi kontras (Batal/Setuju).

---

### 20. Toast Notification
* Notifikasi pojok atas menggunakan integrasi **SweetAlert2** dengan durasi tampilan otomatis 3 detik.
* Desain minimalis tanpa ikon besar, berlatar belakang putih dengan batas tepi kiri berwarna sesuai status notifikasi (sukses = hijau, error = merah).

---

### 21. Empty State
* Kondisi ketika tabel atau list data kosong di dalam database.
* **Desain:** Ikon abu-abu besar di bagian tengah, diikuti pesan penjelasan bahwa data belum tersedia, serta tombol aksi cepat untuk mengarahkan pengguna melakukan pengisian data baru.

---

### 22. Loading State
* Efek pemuatan visual saat mengeksekusi perhitungan TOPSIS atau memuat halaman grafik.
* **Desain:** Tombol berubah status menjadi tidak aktif dengan ikon animasi lingkaran berputar (*spinner-border*) dan teks berubah menjadi "Memproses...".

---

### 23. Error State
* Penanganan visual kesalahan input atau kegagalan sistem.
* **Desain:** Kolom isian yang salah diberikan garis batas merah tegas dengan teks keterangan error kecil berwarna merah di bawahnya menggunakan umpan balik validasi bawaan Bootstrap.

---

### 24. Success State
* Konfirmasi keberhasilan penyimpanan data atau penyelesaian perhitungan.
* **Desain:** Notifikasi pop-up SweetAlert2 dengan animasi tanda centang hijau melingkar yang halus dan rapi.

---

### 25. Pagination
* Navigasi pembagi halaman tabel menggunakan gaya minimalis Bootstrap 5.
* Tombol aktif disorot dengan warna latar belakang biru royal `#2563EB` dan tombol tidak aktif dinonaktifkan secara visual.

---

### 26. Breadcrumb
* Penunjuk lokasi navigasi halaman diletakkan di atas judul modul.
* Menggunakan warna abu-abu pudar dengan pembatas garis miring (*slash*) tipis untuk membedakan hirarki folder menu.

---

### 27. Search Box
* Kotak pencarian data master dilengkapi ikon Bootstrap Icons kaca pembesar (`bi-search`) di sisi kiri kolom input untuk estetika visual modern.

---

### 28. Filter
* Dropdown penyaring kategori proyek atau status AI diletakkan sejajar di samping search box dengan warna latar belakang abu-abu terang sekunder.

---

### 29. Chart Style
* **Grafik Lingkaran (Doughnut):** Dataset dibatasi maksimal 5 nilai dominan dengan warna palet yang kontras namun lembut.
* **Grafik Batang (Bar):** Batang vertikal menggunakan warna biru royal `#2563EB` dengan tingkat transparansi halus (`rgba(37, 99, 235, 0.85)`) dan garis batas tegas.

---

### 30. Responsive Rules
* **Layar Desktop (> 992px):** Sidebar tampil penuh secara statis di sisi kiri.
* **Layar Tablet/Mobile (< 992px):** Sidebar disembunyikan otomatis. Pengguna dapat membuka menu melalui tombol menu hamburger di pojok kiri atas topbar. Konten tabel otomatis mengaktifkan scroll horizontal.

---

### 31. Accessibility
* Kontras warna teks utama terhadap latar belakang putih mematuhi standar rasio keterbacaan WCAG AA.
* Seluruh form isian wajib dilengkapi dengan atribut label dan input `id` yang berpasangan secara eksplisit agar dapat dibaca dengan baik oleh pembaca layar (*screen reader*).
