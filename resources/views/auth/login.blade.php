<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AInsight</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            --text-main: #0f172a;
            --text-secondary: #475569;
            --border-light: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* Abstract Light Blue Gradient Shapes */
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 1;
            opacity: 0.5;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: #93c5fd;
            top: -50px;
            left: -50px;
        }

        .shape-2 {
            width: 350px;
            height: 350px;
            background: #c084fc;
            bottom: -80px;
            right: -50px;
        }

        /* Modern Enterprise Login Card */
        .login-card {
            width: 100%;
            max-width: 460px;
            background: #ffffff;
            border: 1px solid var(--border-light);
            border-radius: 20px;
            padding: 2.75rem 2.5rem;
            z-index: 10;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .brand-logo-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            background: var(--primary-gradient);
            border-radius: 12px;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.25);
        }

        .brand-logo-container i {
            font-size: 1.6rem;
            color: #ffffff;
        }

        .form-control {
            background: #f8fafc;
            border: 1px solid var(--border-light);
            color: var(--text-main);
            border-radius: 10px;
            padding: 0.7rem 0.9rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            color: var(--text-main);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-bottom: 0.35rem;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            color: #ffffff;
            font-weight: 700;
            border-radius: 10px;
            padding: 0.75rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            font-size: 0.92rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert-custom {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            color: #b91c1c;
            border-radius: 10px;
            font-size: 0.8rem;
            padding: 0.7rem 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Background shapes -->
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>

    <!-- Login card -->
    <div class="login-card">
        <div class="text-center">
            <div class="brand-logo-container">
                <i class="bi bi-cpu-fill"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.02em; font-size: 1.5rem;">A<span>Insight</span></h4>
            <p class="text-secondary small mb-2 fw-semibold" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em;">Decision Support System</p>
            <p class="text-muted small mb-4" style="font-size: 0.78rem; line-height: 1.4;">Sistem Pendukung Keputusan Pemilihan Artificial Intelligence menggunakan metode TOPSIS</p>
        </div>

        @if(session('error'))
            <div class="alert alert-custom mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Form without required attributes to disable HTML5 browser validation -->
        <form action="{{ route('login.post') }}" method="POST" novalidate>
            @csrf

            <!-- Email field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Korporat</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 border-light-subtle text-secondary" style="border-radius: 10px 0 0 10px;"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control border-start-0 @error('email') is-invalid @enderror" placeholder="nama@ainsight.test" value="{{ old('email') }}" style="border-radius: 0 10px 10px 0;">
                </div>
                @error('email')
                    <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password field -->
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 border-light-subtle text-secondary" style="border-radius: 10px 0 0 10px;"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="••••••••" style="border-radius: 0 10px 10px 0;">
                </div>
                @error('password')
                    <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember me checkbox -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" style="border-color: #cbd5e1;">
                    <label class="form-check-label small text-secondary fw-semibold" for="remember">Ingat Saya</label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-login w-100 mb-2">
                Masuk Sistem <i class="bi bi-arrow-right-short ms-1"></i>
            </button>
        </form>

        <div class="text-center mt-3">
            <span class="small text-secondary" style="font-size: 0.7rem;">&copy; {{ date('Y') }} Notch Creative. All rights reserved.</span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
