<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AInsight - SPK Pemilihan AI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=landing">AInsight</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <!-- [DEV MODE] Masuk & Daftar buttons hidden during development -->
                <!-- [RESTORE] Uncomment below when authentication is re-enabled:
                <li class="nav-item">
                    <a class="nav-link text-dark me-3" href="index.php?page=login">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="index.php?page=register">Daftar</a>
                </li>
                -->
                <a class="btn btn-primary" href="index.php?page=dashboard">Masuk ke Dashboard</a>
            </ul>
        </div>
    </div>
</nav>

<header class="hero-section text-center">
    <div class="container">
        <h1 class="hero-title mb-4">Sistem Pendukung Keputusan Pemilihan Penggunaan AI</h1>
        <p class="hero-subtitle lead mb-5">Membantu Tim Kreatif di Notch Creative Agency Memilih AI Terbaik Menggunakan Metode TOPSIS</p>
        <!-- [DEV MODE] CTA langsung ke Dashboard; [RESTORE] ubah href ke index.php?page=login -->
        <a href="index.php?page=dashboard" class="btn btn-primary btn-lg px-5 py-3 shadow-sm">Masuk ke Dashboard</a>
    </div>
</header>

<div class="container my-5 py-4">
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="card card-custom p-4 h-100">
                <h4 class="mb-3 text-primary">1. Input Kebutuhan</h4>
                <p class="text-muted">Masukkan nama proyek Anda dan tentukan tingkat kepentingan (bobot) untuk setiap kriteria AI yang dinilai.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-4 h-100">
                <h4 class="mb-3 text-primary">2. Proses TOPSIS</h4>
                <p class="text-muted">Sistem akan melakukan perhitungan matematis secara terperinci menggunakan metode TOPSIS berdasarkan skor alternatif.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom p-4 h-100">
                <h4 class="mb-3 text-primary">3. Rekomendasi Akurat</h4>
                <p class="text-muted">Dapatkan ranking AI terbaik serta penjelasan terperinci mengenai hasil perhitungan matematika tersebut.</p>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 bg-white border-top">
    <p class="text-muted mb-0">&copy; 2026 AInsight - Notch Creative Agency Decision Support System.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
