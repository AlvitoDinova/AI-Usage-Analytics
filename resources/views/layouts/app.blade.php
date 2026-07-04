<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AInsight') - SPK Pemilihan AI</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Custom Style Sheet -->
    <style>
        :root {
            --primary-color: #2563EB;
            --secondary-color: #F8FAFC;
            --background-color: #FFFFFF;
            --border-color: #E5E7EB;
            --text-color: #1E293B;
            --text-muted: #64748B;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            font-size: 0.85rem;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--background-color);
            border-right: 1px solid var(--border-color);
            padding: 1rem 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 0 1.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .sidebar-brand h5 {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-color);
            margin: 0;
        }

        .sidebar-brand h5 span {
            color: var(--primary-color);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu-header {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            padding: 0.75rem 1.5rem 0.25rem 1.5rem;
        }

        .sidebar-menu-item a {
            display: flex;
            align-items: center;
            padding: 0.65rem 1.5rem;
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .sidebar-menu-item a i {
            font-size: 1.1rem;
            margin-right: 0.75rem;
            color: var(--text-muted);
        }

        .sidebar-menu-item a:hover {
            background-color: var(--secondary-color);
        }

        .sidebar-menu-item.active a {
            background-color: rgba(37, 99, 235, 0.08);
            color: var(--primary-color);
            font-weight: 600;
        }

        .sidebar-menu-item.active a i {
            color: var(--primary-color);
        }

        /* Topbar & Workspace */
        .workspace {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 56px;
            background-color: var(--background-color);
            border-bottom: 1px solid var(--border-color);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-title {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0;
        }

        .topbar-date {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .footer {
            background-color: var(--background-color);
            border-top: 1px solid var(--border-color);
            padding: 1rem 2rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Card Customizations */
        .card {
            background-color: var(--background-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        }

        .card-header-title {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin: 0;
        }

        /* Widget Metric */
        .metric-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar Menu -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h5>A<span>Insight</span></h5>
            <small class="text-muted d-block" style="font-size: 0.65rem;">Decision Support System</small>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-menu-header">Umum</li>
            <li class="sidebar-menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="bi bi-grid-fill"></i>Dashboard</a>
            </li>
            
            <li class="sidebar-menu-header">Data Master</li>
            <li class="sidebar-menu-item {{ Request::is('ai-tools*') ? 'active' : '' }}">
                <a href="{{ route('ai-tools.index') }}"><i class="bi bi-robot"></i>Data AI Tools</a>
            </li>
            <li class="sidebar-menu-item {{ Request::is('criteria*') ? 'active' : '' }}">
                <a href="{{ route('criteria.index') }}"><i class="bi bi-list-stars"></i>Data Kriteria</a>
            </li>
            <li class="sidebar-menu-item {{ Request::is('criterion-weights*') ? 'active' : '' }}">
                <a href="{{ route('criterion-weights.index') }}"><i class="bi bi-percent"></i>Bobot Kriteria</a>
            </li>
            <li class="sidebar-menu-item {{ Request::is('project-types*') ? 'active' : '' }}">
                <a href="{{ route('project-types.index') }}"><i class="bi bi-folder-fill"></i>Jenis Proyek</a>
            </li>
            <li class="sidebar-menu-item {{ Request::is('matrix*') ? 'active' : '' }}">
                <a href="{{ route('matrix.index') }}"><i class="bi bi-grid-3x3-gap-fill"></i>Matriks Keputusan</a>
            </li>
            
            <li class="sidebar-menu-header">SPK TOPSIS</li>
            <li class="sidebar-menu-item {{ Request::is('projects*') ? 'active' : '' }}">
                <a href="{{ route('projects.index') }}"><i class="bi bi-calculator-fill"></i>Penilaian Proyek</a>
            </li>
            <li class="sidebar-menu-item {{ Request::is('coming-soon*') ? 'active' : '' }}">
                <a href="{{ route('coming-soon') }}"><i class="bi bi-journal-text"></i>Riwayat Evaluasi</a>
            </li>
        </ul>
    </div>

    <!-- Main Content Workspace -->
    <div class="workspace">
        <div class="topbar">
            <div>
                <h6 class="topbar-title">Notch Creative Agency — Dashboard</h6>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1" style="font-size: 0.65rem;">DEV MODE</span>
                <span class="topbar-date" id="live-time"></span>
            </div>
        </div>

        <div class="main-content">
            <!-- Flash Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} <strong>AInsight</strong>. All Rights Reserved. Skripsi TOPSIS SPK AI.
        </div>
    </div>

    <!-- JS CDN Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Update Time script
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            document.getElementById('live-time').innerText = now.toLocaleDateString('id-ID', options);
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    @yield('scripts')
</body>
</html>
