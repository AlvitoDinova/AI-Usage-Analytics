# Product Requirements Document (PRD)
## Sistem Pendukung Keputusan Pemilihan Penggunaan AI pada Industri Kreatif di Notch Creative Agency Menggunakan Metode TOPSIS (AInsight)

---

### 1. Executive Summary
**AInsight** adalah sebuah Sistem Pendukung Keputusan (SPK) berbasis web yang dirancang khusus untuk membantu tim kreatif di **Notch Creative Agency, Tangerang Selatan**, dalam memilih perangkat kecerdasan buatan (AI Tools) terbaik dan paling relevan dengan kebutuhan proyek kreatif mereka. Sistem ini mengadopsi metode **TOPSIS** (*Technique for Order of Preference by Similarity to Ideal Solution*) untuk melakukan analisis multikriteria terhadap berbagai alternatif AI. AInsight bertujuan untuk mengeliminasi subjektivitas pemilihan tools, mengoptimalkan alokasi anggaran langganan software, dan meningkatkan efisiensi operasional agensi kreatif.

---

### 2. Background
Perkembangan teknologi kecerdasan buatan (Generative AI) telah melahirkan ratusan aplikasi AI dengan spesialisasi yang berbeda-beda—mulai dari teks, desain grafis, video editing, hingga pemrograman. Di industri kreatif seperti Notch Creative Agency, penggunaan AI telah menjadi kebutuhan primer untuk mempercepat produksi aset. 

Namun, banyaknya pilihan AI sering kali menimbulkan kebingungan bagi tim kreatif (desainer, copywriter, videografer). Sering terjadi situasi di mana agensi berlangganan alat yang mahal namun jarang digunakan, atau tim menggunakan alat gratis dengan kualitas di bawah standar proyek. Oleh karena itu, diperlukan sebuah sistem terstandardisasi yang dapat memberikan rekomendasi objektif berdasarkan kriteria-kriteria spesifik dari jenis proyek yang sedang ditangani.

---

### 3. Problem Statement
1. **Subjektivitas Tinggi:** Pemilihan AI Tool oleh tim kreatif saat ini hanya didasarkan pada intuisi individu atau tren pasar tanpa analisis kecocokan kriteria teknis proyek.
2. **Inefisiensi Biaya:** Agensi tidak memiliki data standardisasi performa berbanding harga (cost-benefit) dari alat-alat AI yang dibeli.
3. **Ketidaksesuaian Output:** Perangkat AI yang dipilih kerap kali tidak sesuai dengan karakteristik tipe proyek (misalnya, proyek penulisan naskah menggunakan model AI yang lemah dalam pemahaman kontekstual Bahasa Indonesia).

---

### 4. Goals
* Menghasilkan platform SPK yang mampu memberikan rekomendasi AI alternatif secara cepat, objektif, dan akurat berdasarkan karakteristik proyek Notch Creative Agency.
* Mengurangi pemborosan anggaran lisensi AI Tools di agensi dengan memprioritaskan alat serbaguna yang memiliki skor efektivitas tertinggi.

---

### 5. Objectives
1. Menerapkan algoritma perhitungan TOPSIS secara lengkap ke dalam sistem backend.
2. Mengakomodasi setidaknya 10 kriteria evaluasi utama (seperti akurasi, harga, kemudahan, dll.) dan 13 alternatif AI terpopuler di industri kreatif.
3. Menyediakan antarmuka dashboard interaktif untuk memonitor statistik rekomendasi terpopuler dan riwayat proyek agensi.

---

### 6. Stakeholders
* **Peneliti (Mahasiswa):** Pemilik skripsi yang merancang sistem, basis data, dan mengimplementasikan metode TOPSIS.
* **Notch Creative Agency (Manajemen/Direktur):** Pemilik kebijakan anggaran yang akan menggunakan statistik sistem sebagai bahan evaluasi biaya langganan software.
* **Tim Kreatif (User):** Desainer grafis, copywriter, motion designer, developer, dan social media specialist yang akan menggunakan rekomendasi sistem untuk mengeksekusi proyek harian.

---

### 7. Target Users
1. **Administrator (Operation/IT Lead):** Bertanggung jawab memperbarui data alternatif AI, menyesuaikan kriteria evaluasi, mengelola nilai matriks keputusan global, serta memantau audit trail sistem.
2. **User (Creative Team):** Bertanggung jawab menginput parameter proyek baru, menentukan bobot kepentingan kriteria proyek, dan melihat hasil ranking rekomendasi untuk dieksekusi.

---

### 8. Scope
* Manajemen data pengguna (Admin & User).
* Manajemen tipe proyek kreatif (Copywriting, Graphic Design, Branding, dll.).
* Manajemen alternatif AI Tools beserta metadata pendukung (kategori, deskripsi, website).
* Manajemen kriteria TOPSIS (Tipe Benefit/Cost) beserta bobot default-nya.
* Pengisian matriks keputusan global (skala 1-5) yang mempertemukan Alternatif × Kriteria.
* Simulasi penilaian proyek dengan pembobotan dinamis dari sisi user.
* Eksekusi kalkulasi metode TOPSIS langkah-demi-langkah (termasuk penyimpanan log perhitungan dalam format JSON).
* Dashboard statistik dan grafik visual.

---

### 9. Out of Scope
* Integrasi API langsung dengan sistem eksternal AI Tools (sistem tidak melakukan *generate content* atau mengeksekusi prompt AI).
* Sistem pembayaran/langganan lisensi aplikasi secara langsung (sistem hanya memberikan rekomendasi pilihan).
* Manajemen proyek tingkat lanjut (tidak ada fitur Kanban Board, Gantt Chart, atau task assignment seperti Trello/Jira).

---

### 10. Functional Requirements

| ID | Modul | Deskripsi Kebutuhan Fungsional | Aktor |
|---|---|---|---|
| FR-01 | Auth | Mengamankan akses halaman administrasi dan user. | Admin, User |
| FR-02 | Dashboard | Menampilkan ringkasan jumlah data master dan grafik statistik penggunaan. | Admin, User |
| FR-03 | AI Management | CRUD (Create, Read, Update, Delete) data alternatif AI Tools. | Admin |
| FR-04 | Criteria Mgmt | CRUD kriteria penilaian dan penentuan tipe (Benefit/Cost). | Admin |
| FR-05 | Decision Matrix | Mengisi dan mengubah skor performa alternatif terhadap kriteria (skala 1-5). | Admin |
| FR-06 | Project Type | Mengelola kategori jenis pekerjaan kreatif agensi. | Admin |
| FR-07 | Assessment | Membuat data evaluasi proyek baru dan mengisi tingkat prioritas kriteria. | User |
| FR-08 | TOPSIS Engine | Melakukan kalkulasi matematis TOPSIS secara otomatis. | System |
| FR-09 | Ranking Result | Menampilkan daftar ranking AI dari nilai preferensi tertinggi ke terendah. | User |
| FR-10 | History | Menyimpan dan menampilkan log hasil penilaian terdahulu. | Admin, User |
| FR-11 | Statistics | Menyajikan tren AI paling direkomendasikan dan statistik jenis proyek. | Admin |

---

### 11. Non-Functional Requirements
* **Usability:** Antarmuka bersih, menggunakan Bootstrap 5 dengan navigasi sidebar yang konsisten di semua resolusi layar.
* **Security:** Perlindungan terhadap SQL Injection menggunakan PDO Prepared Statement, pencegahan Cross-Site Request Forgery (CSRF), dan penyimpanan sandi menggunakan enkripsi aman (bcrypt).
* **Performance:** Waktu respon eksekusi perhitungan TOPSIS tidak boleh melebihi 2 detik untuk 13 alternatif dan 10 kriteria.
* **Reliability:** Data perhitungan matematis harus konsisten dan disimpan ke database agar tidak hilang saat session browser berakhir.

---

### 12. User Stories
* **Sebagai Admin,** saya ingin memperbarui nilai performa (matriks keputusan) ChatGPT ketika ada rilis versi terbaru (misalnya GPT-4o), sehingga hasil rekomendasi yang dihasilkan sistem tetap akurat dan relevan dengan kapabilitas alat saat ini.
* **Sebagai Tim Kreatif,** saya ingin memasukkan spesifikasi proyek desain brosur yang membutuhkan kriteria "Kemampuan Desain" bernilai sangat penting (5) dan "Kemampuan Coding" bernilai tidak penting (1), agar saya mendapatkan rekomendasi tools AI desain terbaik seperti Midjourney atau Leonardo AI secara instan.

---

### 13. Use Cases
* **Admin:** Mengelola Alternatif, Kriteria, dan mengatur Matriks Keputusan global.
* **User:** Menginput parameter proyek baru, menyesuaikan bobot kriteria, memproses perhitungan TOPSIS, dan melihat ranking alternatif.
* **System:** Melakukan normalisasi data, perkalian bobot, pencarian solusi ideal, dan perhitungan preferensi.

---

### 14. User Flow
1. **User/Admin** membuka Landing Page dan login.
2. Pengguna dialihkan ke halaman **Dashboard**.
3. Admin dapat memperbarui alternatif, kriteria, dan matriks keputusan global di menu **Data Master**.
4. User memilih menu **Penilaian Proyek**, memasukkan nama proyek, tipe proyek, serta menggeser slider bobot (1-5).
5. Sistem mengeksekusi TOPSIS dan menampilkan hasil rekomendasi di **Hasil Ranking**.

---

### 15. Information Architecture
AInsight dikelompokkan ke dalam 3 menu navigasi utama:
* **Umum:** Dashboard (ringkasan & visualisasi chart).
* **Data Master (Admin):** Data AI, Kriteria, Matriks Keputusan, Jenis Proyek.
* **SPK TOPSIS (User):** Penilaian Proyek, Hasil Ranking, Riwayat.

---

### 16. Feature List
1. **Dashboard Widgets:** Total AI, kriteria, penilaian, dan proyek terhitung.
2. **ChartJS Chart:** Diagram batang kategori proyek dan diagram lingkaran alternatif terpopuler.
3. **Decision Matrix Grid:** Tabel silang satu arah untuk mempermudah pembaruan kinerja AI.
4. **Calculations Step Tracer:** Rincian perhitungan matematis normalisasi dan jarak solusi.

---

### 17. Business Process
1. Administrator menetapkan set data alternatif dan kriteria evaluasi dasar.
2. Tim kreatif mendaftarkan proyek baru yang sedang dikerjakan agensi.
3. Tim kreatif memberikan prioritas bobot kriteria yang sesuai dengan proyek tersebut.
4. Sistem menjalankan evaluasi TOPSIS dan menampilkan peringkat rekomendasi terbaik.

---

### 18. TOPSIS Workflow
1. Matriks Keputusan $X$ berukuran $m \times n$.
2. Normalisasi Matriks $R$ dengan membagi nilai sel dengan akar kuadrat jumlah kuadrat sel kolom.
3. Pembobotan Matriks $Y$ dengan mengalikan $R$ dengan bobot dinamis proyek.
4. Solusi ideal positif $A^+$ dan negatif $A^-$ dicari berdasarkan tipe Benefit/Cost.
5. Jarak solusi ideal positif $D^+$ dan negatif $D^-$ dihitung dengan rumus Euclidean.
6. Nilai preferensi $C_i = D^- / (D^+ + D^-)$.
7. Pengurutan $C_i$ secara descending untuk menentukan ranking.

---

### 19. CRUD Requirements
* Formulir dilengkapi validasi tipe data dan batasan constraint database.
* Keunikan nama alternatif dan kode kriteria diproteksi ketat.

---

### 20. Dashboard Requirements
* Statistik grafik batang memetakan sebaran tipe proyek.
* Statistik lingkaran memetakan persentase rekomendasi AI peringkat teratas.

---

### 21. Reporting Requirements
* Penyajian langkah perhitungan TOPSIS.
* Fitur ekspor hasil ke format PDF atau Excel.

---

### 22. Error Handling Requirements
* Halaman error ramah pengguna (404, 500) tanpa mengekspos rahasia stack trace SQL.
* Validasi kesalahan masukan langsung di UI dengan Bootstrap alert.

---

### 23. Security Requirements
* PDO Prepared Statement menangkal SQL Injection.
* Validasi token CSRF melindungi form request POST.
* HTML escaping `htmlspecialchars` melindungi dari Cross-Site Scripting (XSS).

---

### 24. Performance Requirements
* Waktu respons rendering database di bawah 1 detik.
* Optimasi query data master menggunakan Eager Loading relasi.

---

### 25. Responsive Requirements
* Navigasi sidebar tersembunyi (*offcanvas*) saat diakses lewat layar ponsel pintar.
* Tabel matriks keputusan menggunakan *responsive wrapper* Bootstrap agar dapat digeser horizontal di layar kecil.

---

### 26. Future Development
* **Integrasi Metode AHP:** Membantu tim menentukan pembobotan kriteria secara konsisten sebelum masuk ke tahap TOPSIS.
* **Dynamic Criteria Creation:** Penambahan kriteria baru secara tak terbatas langsung dari antarmuka web.
