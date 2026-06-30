<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="AInsight SPK - Dashboard pusat sistem pendukung keputusan pemilihan AI untuk Notch Creative Agency.">
    <title>Dashboard - AInsight SPK</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        /* ── App Shell ── */
        html, body { height: 100%; }
        body { display: flex; flex-direction: column; background-color: var(--light-bg); }

        /* ── Top Navbar ── */
        .topbar {
            background-color: #fff;
            border-bottom: 1px solid var(--card-border);
            height: 56px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: var(--shadow-sm);
        }
        .topbar .brand {
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--primary-blue);
            text-decoration: none;
            letter-spacing: -0.3px;
        }
        .topbar .dev-badge {
            font-size: 0.65rem;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffc107;
            border-radius: 6px;
            padding: 2px 8px;
            margin-left: 10px;
            font-weight: 600;
        }

        /* ── Sidebar ── */
        #sidebar {
            width: 240px;
            min-height: calc(100vh - 56px);
            background: #fff;
            border-right: 1px solid var(--card-border);
            position: fixed;
            top: 56px;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            transition: transform 0.25s ease;
            z-index: 1020;
        }
        #sidebar .sidebar-section {
            padding: 18px 16px 6px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: #94a3b8;
            text-transform: uppercase;
        }
        #sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-dark);
            border-radius: 8px;
            margin: 2px 8px;
            transition: background 0.15s, color 0.15s;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 18px; }
        #sidebar .nav-link:hover { background: var(--light-bg); color: var(--primary-blue); }
        #sidebar .nav-link.active {
            background: rgba(13,110,253,0.1);
            color: var(--primary-blue);
            font-weight: 600;
        }
        #sidebar .nav-link .badge-soon {
            font-size: 0.6rem;
            background: #e2e8f0;
            color: #64748b;
            padding: 2px 7px;
            border-radius: 999px;
            margin-left: auto;
        }

        /* ── Main Content ── */
        #main-content {
            margin-left: 240px;
            padding: 28px 28px 40px;
            flex: 1;
        }

        /* ── Stat Cards ── */
        .stat-card {
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }
        .stat-icon.blue  { background: rgba(13,110,253,0.1); color: #0d6efd; }
        .stat-icon.green { background: rgba(25,135,84,0.1);  color: #198754; }
        .stat-icon.amber { background: rgba(255,193,7,0.12); color: #d97706; }
        .stat-icon.red   { background: rgba(220,53,69,0.1);  color: #dc3545; }
        .stat-label { font-size: 0.78rem; color: var(--text-muted); margin-bottom: 2px; }
        .stat-val   { font-size: 1.65rem; font-weight: 700; color: var(--text-dark); line-height: 1.1; }

        /* ── Quick-action Cards ── */
        .action-card {
            background: #fff;
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 22px;
            height: 100%;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .action-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); color: inherit; }
        .action-card .ac-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; margin-bottom: 12px;
        }
        .action-card h6 { font-weight: 700; margin-bottom: 4px; font-size: 0.9rem; }
        .action-card p  { font-size: 0.78rem; color: var(--text-muted); margin: 0; }

        /* ── Pipeline Steps ── */
        .pipeline {
            display: flex;
            gap: 0;
            flex-wrap: wrap;
        }
        .pipeline-step {
            flex: 1;
            min-width: 110px;
            background: #fff;
            border: 1px solid var(--card-border);
            border-right: none;
            padding: 16px 14px;
            position: relative;
            text-align: center;
        }
        .pipeline-step:first-child { border-radius: 12px 0 0 12px; }
        .pipeline-step:last-child  { border-radius: 0 12px 12px 0; border-right: 1px solid var(--card-border); }
        .pipeline-step .step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(13,110,253,0.1); color: var(--primary-blue);
            font-weight: 700; font-size: 0.8rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 8px;
        }
        .pipeline-step .step-label { font-size: 0.72rem; font-weight: 600; color: var(--text-dark); }
        .pipeline-step .step-sub   { font-size: 0.68rem; color: var(--text-muted); margin-top: 2px; }

        /* ── Section Title ── */
        .section-title {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        /* ── Dev Notice Banner ── */
        .dev-notice {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.8rem;
            color: #92400e;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #main-content { margin-left: 0; padding: 18px; }
        }
    </style>
</head>
<body>

<!-- ═══════════════════════ TOP NAVBAR ═══════════════════════ -->
<div class="topbar">
    <a href="index.php?page=dashboard" class="brand">AInsight</a>
    <span class="dev-badge"><i class="bi bi-tools me-1"></i>DEV MODE</span>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-muted" style="font-size:0.8rem;">
            <i class="bi bi-calendar3 me-1"></i><?php echo date('d M Y'); ?>
        </span>
        <!-- [RESTORE] Replace the badge below with a real user-info + logout button when auth is active -->
        <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size:0.75rem;">
            <i class="bi bi-person-fill me-1"></i>Developer
        </span>
    </div>
</div>

<!-- ═══════════════════════ SIDEBAR ═══════════════════════ -->
<nav id="sidebar">
    <div class="py-2">

        <div class="sidebar-section">Umum</div>
        <a href="index.php?page=dashboard" class="nav-link active" id="nav-dashboard">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-section">Data Master</div>
        <a href="index.php?page=ai-tools" class="nav-link" id="nav-ai-tools">
            <i class="bi bi-robot"></i> Data AI (Alternatif)
        </a>
        <a href="index.php?page=criteria" class="nav-link" id="nav-criteria">
            <i class="bi bi-list-check"></i> Data Kriteria
        </a>
        <a href="index.php?page=matrix" class="nav-link" id="nav-matrix">
            <i class="bi bi-table"></i> Matriks Keputusan
        </a>

        <div class="sidebar-section">SPK TOPSIS</div>
        <a href="index.php?page=assess" class="nav-link" id="nav-assess">
            <i class="bi bi-pencil-square"></i> Penilaian Proyek
        </a>
        <a href="index.php?page=result" class="nav-link" id="nav-result">
            <i class="bi bi-bar-chart-line"></i> Hasil Ranking
        </a>
        <a href="index.php?page=history" class="nav-link" id="nav-history">
            <i class="bi bi-clock-history"></i> Riwayat Perhitungan
        </a>

        <div class="sidebar-section">Akun</div>
        <!-- [RESTORE] Uncomment the links below when authentication is re-enabled -->
        <!--
        <a href="index.php?page=profile" class="nav-link">
            <i class="bi bi-person-circle"></i> Profil Saya
        </a>
        <a href="index.php?page=logout" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
        -->
        <a href="index.php?page=profile" class="nav-link">
            <i class="bi bi-person-circle"></i> Profil <span class="badge-soon">Soon</span>
        </a>
        <a href="index.php?page=landing" class="nav-link">
            <i class="bi bi-house"></i> Landing Page
        </a>
    </div>
</nav>

<!-- ═══════════════════════ MAIN CONTENT ═══════════════════════ -->
<div id="main-content">

    <!-- Dev Notice -->
    <div class="dev-notice">
        <i class="bi bi-info-circle-fill fs-5"></i>
        <span><strong>Mode Pengembangan Aktif:</strong> Autentikasi dinonaktifkan sementara. Semua fitur dapat diakses langsung tanpa login. Aktifkan kembali di <code>DashboardController.php</code> &amp; <code>index.php</code> setelah pengembangan selesai.</span>
    </div>

    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="font-size:1.5rem; color:var(--text-dark);">Dashboard SPK</h1>
            <p class="text-muted mb-0" style="font-size:0.85rem;">Pusat sistem pendukung keputusan pemilihan AI - Notch Creative Agency</p>
        </div>
        <a href="index.php?page=assess" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-play-circle"></i> Mulai Penilaian
        </a>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-robot"></i></div>
                <div>
                    <div class="stat-label">Total AI Alternatif</div>
                    <div class="stat-val">—</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-list-check"></i></div>
                <div>
                    <div class="stat-label">Total Kriteria</div>
                    <div class="stat-val">—</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon amber"><i class="bi bi-clipboard-data"></i></div>
                <div>
                    <div class="stat-label">Penilaian Selesai</div>
                    <div class="stat-val">—</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon red"><i class="bi bi-trophy"></i></div>
                <div>
                    <div class="stat-label">AI Terpilih</div>
                    <div class="stat-val">—</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── TOPSIS Pipeline ── -->
    <div class="mb-4">
        <div class="section-title">Alur Perhitungan TOPSIS</div>
        <div class="pipeline">
            <div class="pipeline-step">
                <div class="step-num">1</div>
                <div class="step-label">Input Data</div>
                <div class="step-sub">AI &amp; Kriteria</div>
            </div>
            <div class="pipeline-step">
                <div class="step-num">2</div>
                <div class="step-label">Bobot</div>
                <div class="step-sub">Tingkat Kepentingan</div>
            </div>
            <div class="pipeline-step">
                <div class="step-num">3</div>
                <div class="step-label">Matriks</div>
                <div class="step-sub">Nilai Keputusan</div>
            </div>
            <div class="pipeline-step">
                <div class="step-num">4</div>
                <div class="step-label">Normalisasi</div>
                <div class="step-sub">Matriks Ternormalisasi</div>
            </div>
            <div class="pipeline-step">
                <div class="step-num">5</div>
                <div class="step-label">Solusi Ideal</div>
                <div class="step-sub">A+ &amp; A−</div>
            </div>
            <div class="pipeline-step">
                <div class="step-num">6</div>
                <div class="step-label">Jarak</div>
                <div class="step-sub">D+ &amp; D−</div>
            </div>
            <div class="pipeline-step">
                <div class="step-num">7</div>
                <div class="step-label">Skor &amp; Rank</div>
                <div class="step-sub">Ci &amp; Ranking</div>
            </div>
        </div>
    </div>

    <!-- ── Quick Action Cards ── -->
    <div class="mb-2">
        <div class="section-title">Akses Cepat Fitur</div>
    </div>
    <div class="row g-3">

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=ai-tools" class="action-card">
                <div class="ac-icon blue"><i class="bi bi-robot"></i></div>
                <h6>Data AI (Alternatif)</h6>
                <p>Kelola daftar AI tools yang menjadi alternatif pilihan dalam evaluasi.</p>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=criteria" class="action-card">
                <div class="ac-icon green"><i class="bi bi-list-check"></i></div>
                <h6>Data Kriteria</h6>
                <p>Atur kriteria penilaian seperti biaya, akurasi, kemudahan, dan integrasi.</p>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=matrix" class="action-card">
                <div class="ac-icon" style="background:rgba(99,102,241,0.1);color:#6366f1;"><i class="bi bi-table"></i></div>
                <h6>Matriks Keputusan</h6>
                <p>Input dan kelola matriks nilai setiap AI terhadap masing-masing kriteria.</p>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=assess" class="action-card">
                <div class="ac-icon amber"><i class="bi bi-pencil-square"></i></div>
                <h6>Penilaian Proyek</h6>
                <p>Tentukan bobot kepentingan kriteria untuk proyek yang sedang berjalan.</p>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=result" class="action-card">
                <div class="ac-icon" style="background:rgba(20,184,166,0.1);color:#0d9488;"><i class="bi bi-bar-chart-line"></i></div>
                <h6>Perhitungan TOPSIS</h6>
                <p>Jalankan algoritma TOPSIS dan lihat skor preferensi setiap alternatif AI.</p>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=result" class="action-card">
                <div class="ac-icon" style="background:rgba(234,179,8,0.12);color:#ca8a04;"><i class="bi bi-trophy"></i></div>
                <h6>Hasil Ranking</h6>
                <p>Tampilkan AI terbaik berdasarkan nilai Ci TOPSIS dari tertinggi ke terendah.</p>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=history" class="action-card">
                <div class="ac-icon red"><i class="bi bi-clock-history"></i></div>
                <h6>Riwayat Perhitungan</h6>
                <p>Lihat log seluruh sesi penilaian proyek yang pernah dilakukan sebelumnya.</p>
            </a>
        </div>

        <div class="col-md-4 col-lg-3">
            <a href="index.php?page=dashboard" class="action-card">
                <div class="ac-icon" style="background:rgba(139,92,246,0.1);color:#7c3aed;"><i class="bi bi-graph-up-arrow"></i></div>
                <h6>Statistik Penggunaan AI</h6>
                <p>Pantau frekuensi penggunaan dan tren pemilihan AI oleh tim kreatif.</p>
            </a>
        </div>

    </div>
</div><!-- /main-content -->

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
    // Highlight active sidebar link based on current ?page= parameter
    (function () {
        const params = new URLSearchParams(window.location.search);
        const page   = params.get('page') || 'dashboard';
        const map = {
            'dashboard': 'nav-dashboard',
            'ai-tools' : 'nav-ai-tools',
            'criteria' : 'nav-criteria',
            'matrix'   : 'nav-matrix',
            'assess'   : 'nav-assess',
            'result'   : 'nav-result',
            'history'  : 'nav-history',
        };
        document.querySelectorAll('#sidebar .nav-link').forEach(el => el.classList.remove('active'));
        const target = document.getElementById(map[page]);
        if (target) target.classList.add('active');
    })();
</script>
</body>
</html>
