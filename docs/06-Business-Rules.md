# Business Rules Document (BRD)
## Sistem Pendukung Keputusan Pemilihan Penggunaan AI pada Industri Kreatif di Notch Creative Agency Menggunakan Metode TOPSIS (AInsight)

---

### 1. Tujuan Sistem
Sistem Pendukung Keputusan (SPK) AInsight dikembangkan untuk menyediakan analisis evaluasi alternatif AI Tools secara obyektif bagi tim kreatif di Notch Creative Agency. Sistem ini bertujuan menyelaraskan kebutuhan proyek kreatif dengan fitur dan biaya perangkat AI, mengoptimalkan pengeluaran lisensi perangkat lunak, serta menghilangkan subjektivitas personal dalam penentuan tools kerja.

---

### 2. Definisi Sistem
AInsight adalah sistem pendukung keputusan multikriteria berbasis web yang menerapkan algoritma matematika **TOPSIS** (*Technique for Order of Preference by Similarity to Ideal Solution*). Sistem ini mempertemukan alternatif AI Tools dengan kriteria penilaian tertentu menggunakan parameter bobot prioritas dinamis dari proyek yang sedang dievaluasi.

---

### 3. Aktor
Sistem mendefinisikan dua aktor utama dengan peran yang berbeda:
1. **Administrator (IT Operation / Project Lead):** Pengguna dengan otoritas penuh untuk mengelola data master kriteria, nilai performa dasar AI (matriks keputusan), tipe proyek, dan memantau audit trail sistem.
2. **User (Creative Team):** Anggota tim kreatif (Copywriter, Designer, Programmer, Video Editor) yang menggunakan sistem untuk mendaftarkan proyek baru, menginput prioritas bobot kriteria, dan melihat rekomendasi hasil perhitungan TOPSIS.

---

### 4. Hak Akses
Otorisasi hak akses dikelola secara ketat di tingkat backend:
* **Admin Privilege:** Dapat melakukan operasi CRUD (Create, Read, Update, Delete) pada tabel `ai_tools`, `criteria`, `project_types`, dan `matrix_values`. Memiliki hak penuh melihat audit log sistem.
* **User Privilege:** Dibatasi hanya dapat melakukan pendaftaran proyek, pengisian bobot kriteria penilaian, eksekusi kalkulasi TOPSIS, serta melihat riwayat proyek yang pernah dikerjakannya. User dilarang memanipulasi data master kriteria atau nilai dasar matriks keputusan global.

---

### 5. Master Data
* Semua master data wajib mendukung operasi **Create, Read, Update, dan Delete (CRUD)**.
* Penghapusan data master krusial (seperti AI alternatif atau Kriteria) menggunakan mekanisme proteksi relasional database (*database constraints*) untuk mencegah timbulnya data yatim (*orphan data*).
* Gunakan mekanisme penonaktifkan status aktif (`status='nonaktif'`) untuk alternatif AI yang tidak lagi digunakan dibanding menghapus data secara permanen, guna menjaga integritas riwayat penilaian terdahulu.

---

### 6. Project
* Data proyek didefinisikan sebagai entitas pekerjaan agensi yang membutuhkan alat bantu AI.
* Setiap proyek wajib terikat pada satu jenis kategori proyek yang valid di dalam tabel `project_types`.

---

### 7. Assessment (Penilaian Proyek)
* **Aturan Relasi:** Satu proyek kreatif agensi hanya boleh memiliki **satu sesi penilaian (assessment) aktif**.
* Satu assessment memiliki banyak detail masukan nilai kepentingan kriteria yang disimpan dalam tabel `assessment_details`.
* **Aturan Penghapusan:** Assessment yang **sudah menghasilkan ranking keputusan final tidak boleh dihapus** dari sistem untuk mencegah hilangnya riwayat audit laporan keputusan.
* **Aturan Penguncian:** Assessment yang status perhitungannya telah selesai bersifat **Read-Only** (hanya dapat dibaca) dan nilainya tidak boleh diubah kembali oleh pengguna.

---

### 8. Decision Matrix (Matriks Keputusan)
* Matriks keputusan global memetakan nilai kinerja awal seluruh alternatif AI terhadap 10 kriteria evaluasi (skala 1-5).
* Seluruh sel matriks **wajib terisi**. Sistem akan menolak proses kalkulasi TOPSIS jika ditemukan ada nilai kosong atau NULL pada matriks keputusan.

---

### 9. Kriteria
* Setiap kriteria yang didaftarkan wajib memiliki kode unik (K1, K2, dst.), nama kriteria, deskripsi, dan wajib ditetapkan tipenya ke dalam salah satu kategori:
  * **Benefit:** Semakin besar nilai alternatif pada kriteria ini, semakin baik alternatif tersebut dipilih.
  * **Cost:** Semakin kecil nilai alternatif pada kriteria ini, semakin baik alternatif tersebut dipilih.

---

### 10. Bobot
* Bobot default kriteria disimpan oleh Administrator.
* Saat simulasi proyek berjalan, User menginput bobot kepentingan dinamis skala 1-5.
* **Aturan Normalisasi Bobot:** Bobot masukan user tidak wajib berjumlah 100%. Sistem akan secara otomatis melakukan normalisasi bobot di backend dengan membagi nilai bobot setiap kriteria dengan total jumlah bobot seluruh kriteria yang diinput untuk proyek tersebut:
  $$w_j = \frac{W_j}{\sum_{k=1}^{n} W_k}$$

---

### 11. AI Alternatif
* Setiap AI yang didaftarkan sebagai alternatif harus menyertakan nama perangkat, nama pengembang (*developer*), deskripsi fungsionalitas, website resmi, dan kategori spesialisasi kerja.

---

### 12. Dashboard
* Halaman dashboard wajib menampilkan data aktual secara real-time langsung dari database (total alternatif aktif, total proyek, total kriteria, total penilaian selesai).
* **Dilarang keras** menyajikan angka statis atau dummy di dalam widget dashboard.

---

### 13. Riwayat
* Semua hasil akhir perhitungan TOPSIS (nilai preferensi $C_i$, alternatif terpilih, dan ranking) harus disimpan secara permanen di database.
* Pengguna dapat membuka kembali riwayat proyek untuk melihat detail hasil rekomendasi kapan saja.

---

### 14. Statistik
* Statistik tren penggunaan AI paling direkomendasikan dan statistik jenis proyek teraktif dihitung secara dinamis melalui agregasi data transaksi riwayat penilaian.

---

### 15. Audit Trail
* Setiap aktivitas penulisan data (tambah data master, edit matriks, hapus alternatif, eksekusi TOPSIS) wajib dicatat secara otomatis ke dalam tabel `activity_logs` beserta stempel waktu.

---

### 16. Logging
* Kegagalan sistem, pengecualian query SQL, atau error kalkulasi matematika dicatat ke dalam berkas log lokal `storage/logs/laravel.log` dengan tingkat keparahan yang sesuai.

---

### 17. Backup
* Administrator wajib melakukan ekspor berkas database MySQL secara berkala untuk mengantisipasi kegagalan server lokal.

---

### 18. Validasi Data
* Semua input dari form harus melewati validasi ketat menggunakan **Form Request Validation** Laravel sebelum diproses.
* Aturan validasi mencakup tipe data numerik, keberadaan relasi (*exists* database), keunikan (*unique*), dan batasan skala bobot 1-5.

---

### 19. Error Handling
* Pengecekan division by zero dilakukan di backend. Jika pembagi bernilai nol saat normalisasi, sistem menetapkan nilai ternormalisasi menjadi nol untuk menghindari crash.
* Error database ditangkap secara aman dan disajikan dalam halaman error kustom yang rapi.

---

### 20. Future Rules
* Di masa depan, sistem dapat mendukung dinamisasi kriteria baru dari antarmuka web, di mana penambahan kriteria baru otomatis memicu query pengisian sel nilai matriks keputusan default (nilai 3) untuk seluruh alternatif AI aktif yang sudah ada.

---

### 21. Business Rules Perhitungan TOPSIS
Proses perhitungan matematika TOPSIS wajib dijalankan secara berurutan dan terstruktur dengan aturan sebagai berikut:

1. **Pengecekan Awal:** Pastikan tidak ada data sel bernilai kosong di matriks keputusan global.
2. **Normalisasi Matriks:** Matriks keputusan $X_{m \times n}$ dinormalisasi menjadi matriks $R$ menggunakan rumus Euclidean:
   $$r_{ij} = \frac{x_{ij}}{\sqrt{\sum_{i=1}^{m} x_{ij}^2}}$$
3. **Pembobotan Matriks:** Matriks ternormalisasi $R$ dikalikan dengan bobot ternormalisasi kriteria proyek ($w_j$) untuk menghasilkan matriks keputusan terbobot $Y$:
   $$y_{ij} = w_j \times r_{ij}$$
4. **Solusi Ideal Positif ($A^+$):** Dicari dari nilai terbaik kriteria terbobot $Y$. 
   * Jika tipe kriteria adalah **Benefit**, nilai ideal positif adalah nilai maksimum.
   * Jika tipe kriteria adalah **Cost**, nilai ideal positif adalah nilai minimum.
5. **Solusi Ideal Negatif ($A^-$):** Dicari dari nilai terburuk kriteria terbobot $Y$.
   * Jika tipe kriteria adalah **Benefit**, nilai ideal negatif adalah nilai minimum.
   * Jika tipe kriteria adalah **Cost**, nilai ideal negatif adalah nilai maksimum.
6. **Separation Measure (Jarak Jauh):**
   * Jarak alternatif ke solusi ideal positif ($D_i^+$):
     $$D_i^+ = \sqrt{\sum_{j=1}^{n} (y_{ij} - y_j^+)^2}$$
   * Jarak alternatif ke solusi ideal negatif ($D_i^-$):
     $$D_i^- = \sqrt{\sum_{j=1}^{n} (y_{ij} - y_j^-)^2}$$
7. **Nilai Preferensi ($C_i$):** Kedekatan kedekatan relatif dihitung dengan:
   $$C_i = \frac{D_i^-}{D_i^+ + D_i^-}$$
8. **Penyusunan Ranking:** Mengurutkan seluruh alternatif berdasarkan nilai $C_i$ dari yang terbesar hingga terkecil.
9. **Keterbukaan Langkah Perhitungan:** Seluruh matriks antara ($R$, $Y$, koordinat $A^+$/$A^-$, dan nilai $D^+$/$D^-$) disimpan dalam log kalkulasi untuk disajikan secara transparan kepada pengguna.
