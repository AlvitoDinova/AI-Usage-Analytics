<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - AInsight</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=landing">AInsight</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-dark me-3 active" href="index.php?page=login">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="index.php?page=register">Daftar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container d-flex flex-column justify-content-center align-items-center my-auto py-5">
    <div class="card card-custom p-4 w-100 shadow-sm" style="max-width: 400px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">Selamat Datang</h2>
            <p class="text-muted small">Silakan masuk ke akun AInsight Anda</p>
        </div>

        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST">
            <?php if (isset($_SESSION['csrf_token'])): ?>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="username" class="form-label text-dark fw-semibold">Email atau Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="nama@agensi.com atau username" required autofocus>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label text-dark fw-semibold mb-0">Password</label>
                </div>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label text-muted small" for="remember">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2.5 mb-3">Masuk</button>
        </form>

        <div class="text-center">
            <p class="text-muted small mb-0">Belum memiliki akun? <a href="index.php?page=register" class="text-primary fw-semibold">Daftar Sekarang</a></p>
        </div>
    </div>
</div>

<footer class="text-center py-4 bg-white border-top mt-auto">
    <p class="text-muted mb-0">&copy; 2026 AInsight - Notch Creative Agency Decision Support System.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
