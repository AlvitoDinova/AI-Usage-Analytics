# Walkthrough - Sprint 2.2: Laravel Validation Improvement

Pekerjaan standardisasi dan penyelarasan validasi untuk Sprint 2.2 telah diselesaikan dengan sukses. Seluruh interupsi validasi HTML5 bawaan browser telah diganti sepenuhnya menggunakan penanganan server-side Laravel Form Request.

---

### 1. Perubahan Form & Berkas HTML

Atribut `novalidate` telah ditambahkan pada seluruh tag pembuka `<form>` di modul CRUD utama:
*   **AI Tools:** [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai/create.blade.php) & [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/ai/edit.blade.php)
*   **Kriteria:** [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/criteria/create.blade.php) & [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/criteria/edit.blade.php)
*   **Bobot Kriteria:** [index.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/weights/index.blade.php)
*   **Jenis Proyek:** [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/project-types/create.blade.php) & [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/project-types/edit.blade.php)
*   **Penilaian Proyek:** [create.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/create.blade.php) & [edit.blade.php](file:///c:/xampp/htdocs/AInsight/resources/views/admin/projects/edit.blade.php)

---

### 2. Cara Kerja Validasi & Penanganan Error

1.  **Nonaktifkan Validasi Browser:** Penggunaan atribut `novalidate` memaksa browser untuk langsung mengirimkan data form ke server tanpa memicu dialog pop-up HTML5 default browser (*"Please fill out this field"*).
2.  **Validasi Laravel Form Request:** Server memproses inputan menggunakan masing-masing kelas Request (cth: `StoreProjectRequest`, `StoreCriterionWeightRequest`, dll.).
3.  **Pesan Error Terpusat Bahasa Indonesia:** Jika validasi gagal, Laravel mengalihkan kembali ke form asal dengan membagikan error bag dan data lama via `withInput()` / `old()`.
4.  **Tampilan Responsif Bootstrap 5:** 
    *   Setiap elemen input yang terdeteksi error secara dinamis ditambahkan class `.is-invalid` (menampilkan garis tepi merah).
    *   Pesan kesalahan dicetak tepat di bawah input menggunakan blok Bootstrap 5:
        ```html
        @error('nama_field')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        ```
    *   Fungsi helper `old('nama_field')` menjamin data lama yang diketik oleh user tetap tersimpan dan tidak terhapus.

---

### 3. Hasil Pengujian Verifikasi
*   **Pesan HTML5 Hilang:** Terverifikasi 100% gelembung pesan bawaan browser tidak lagi muncul pada seluruh form.
*   **Border Merah is-invalid:** Muncul secara visual dengan presisi di sekeliling input yang bermasalah.
*   **Pesan Error Indonesia:** Menampilkan petunjuk perbaikan berbahasa Indonesia (misal: "Nama proyek wajib diisi", "Bobot minimal adalah 0%").
*   **Integritas Data:** Fungsi edit/simpan tetap berjalan normal ketika seluruh isian form valid.
