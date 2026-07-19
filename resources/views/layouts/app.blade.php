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
            overflow-y: auto;
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

        @media (max-width: 991.98px) {
            .sidebar {
                left: -240px;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }
            .sidebar.show {
                left: 0;
            }
            .workspace {
                margin-left: 0 !important;
            }
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
            <li class="sidebar-menu-item {{ Request::is('about') ? 'active' : '' }}">
                <a href="{{ route('about') }}"><i class="bi bi-info-circle-fill"></i>Tentang Sistem</a>
            </li>
            
            @if(auth()->check())
                @if(auth()->user()->role === 'admin')
                    <li class="sidebar-menu-item {{ Request::is('statistics*') ? 'active' : '' }}">
                        <a href="{{ route('statistics.index') }}"><i class="bi bi-bar-chart-fill"></i>Statistik SPK</a>
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
                    <li class="sidebar-menu-item {{ Request::is('ai-mappings*') ? 'active' : '' }}">
                        <a href="{{ route('ai-mappings.index') }}"><i class="bi bi-shuffle"></i>AI Mapping</a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('matrix*') ? 'active' : '' }}">
                        <a href="{{ route('matrix.index') }}"><i class="bi bi-grid-3x3-gap-fill"></i>Matriks Keputusan</a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('activity-logs*') ? 'active' : '' }}">
                        <a href="{{ route('activity-logs.index') }}"><i class="bi bi-file-earmark-medical-fill"></i>Log Aktivitas</a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('users*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}"><i class="bi bi-people-fill"></i>Manajemen User</a>
                    </li>
                    
                    <li class="sidebar-menu-header">SPK TOPSIS</li>
                    <li class="sidebar-menu-item {{ Request::is('projects*') ? 'active' : '' }}">
                        <a href="{{ route('projects.index') }}"><i class="bi bi-calculator-fill"></i>Penilaian Proyek</a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('history*') ? 'active' : '' }}">
                        <a href="{{ route('history.index') }}"><i class="bi bi-journal-text"></i>Riwayat Evaluasi</a>
                    </li>

                @elseif(auth()->user()->role === 'manager')
                    <li class="sidebar-menu-item {{ Request::is('statistics*') ? 'active' : '' }}">
                        <a href="{{ route('statistics.index') }}"><i class="bi bi-bar-chart-fill"></i>Statistik SPK</a>
                    </li>
                    
                    <li class="sidebar-menu-header">SPK TOPSIS</li>
                    <li class="sidebar-menu-item {{ Request::is('projects*') ? 'active' : '' }}">
                        <a href="{{ route('projects.index') }}"><i class="bi bi-calculator-fill"></i>Penilaian Proyek</a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('history*') ? 'active' : '' }}">
                        <a href="{{ route('history.index') }}"><i class="bi bi-journal-text"></i>Riwayat Evaluasi</a>
                    </li>

                @elseif(auth()->user()->role === 'employee')
                    <li class="sidebar-menu-header">SPK TOPSIS</li>
                    <li class="sidebar-menu-item {{ Request::is('projects*') ? 'active' : '' }}">
                        <a href="{{ route('projects.index') }}"><i class="bi bi-calculator-fill"></i>Project Saya</a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('matrix*') ? 'active' : '' }}">
                        <a href="{{ route('matrix.index') }}"><i class="bi bi-grid-3x3-gap-fill"></i>Input Matriks</a>
                    </li>
                    <li class="sidebar-menu-item {{ Request::is('history*') ? 'active' : '' }}">
                        <a href="{{ route('history.index') }}"><i class="bi bi-journal-text"></i>Riwayat Saya</a>
                    </li>
                @endif
            @endif
        </ul>
    </div>

    <!-- Main Content Workspace -->
    <div class="workspace">
        <div class="topbar d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3 h-auto py-3 py-lg-0 position-relative" style="min-height: 56px;">
            <!-- Sidebar toggle button (absolute positioned on mobile/tablet, hidden on desktop) -->
            <button class="btn btn-sm btn-light border d-lg-none position-absolute start-0 ms-3" type="button" id="sidebar-toggle" style="padding: 0.25rem 0.5rem; top: 12px; z-index: 10;">
                <i class="bi bi-list fs-5"></i>
            </button>
            
            <div class="w-100 text-center text-lg-start flex-grow-1">
                <h6 class="topbar-title mb-0">Notch Creative Agency — Dashboard</h6>
            </div>
            
            <div class="d-flex align-items-center justify-content-center justify-content-lg-end gap-3 flex-wrap w-100 w-lg-auto">
                @if(auth()->check())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2 rounded-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span class="fw-semibold">{{ auth()->user()->name }}</span>
                            @if(auth()->user()->role === 'admin')
                                <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">Admin</span>
                            @elseif(auth()->user()->role === 'manager')
                                <span class="badge bg-warning-subtle text-warning text-dark" style="font-size: 0.65rem;">Manager</span>
                            @else
                                <span class="badge bg-info-subtle text-info text-dark" style="font-size: 0.65rem;">Employee</span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-light-subtle rounded-3" aria-labelledby="userDropdown">
                            <li><h6 class="dropdown-header text-muted small">Status: Aktif</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="px-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger text-white w-100 rounded-2 text-start">
                                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="main-content">
            <!-- Toast notifications are fired via SweetAlert2 scripts at the bottom -->

            @yield('content')
        </div>

        <div class="footer">
            &copy; 2026 <strong>AInsight Version 1.0</strong>. Decision Support System using TOPSIS. Notch Creative Agency.
        </div>
    </div>

    <!-- JS CDN Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>


        document.addEventListener('DOMContentLoaded', function() {
            // Responsive Sidebar Toggle
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                });
                document.addEventListener('click', function(e) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }

            // Flash notification modals (SweetAlert2)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: {!! json_encode(session('success')) !!},
                    confirmButtonColor: '#2563EB'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: {!! json_encode(session('error')) !!},
                    confirmButtonColor: '#2563EB'
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Error Validasi',
                    text: {!! json_encode($errors->first()) !!},
                    confirmButtonColor: '#2563EB'
                });
            @endif

            // Global Double-Click and loading state prevention on form submit
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                    
                    submitButtons.forEach(button => {
                        if (button.disabled) {
                            e.preventDefault();
                            return;
                        }
                        
                        button.disabled = true;
                        button.dataset.originalHtml = button.innerHTML;
                        
                        let text = button.innerText.trim();
                        let loadingText = 'Memproses...';
                        
                        if (text.toLowerCase().includes('simpan')) {
                            loadingText = 'Menyimpan...';
                        } else if (text.toLowerCase().includes('hitung')) {
                            loadingText = 'Menghitung TOPSIS...';
                        } else if (text.toLowerCase().includes('tambah')) {
                            loadingText = 'Menambahkan...';
                        } else if (text.toLowerCase().includes('hapus')) {
                            loadingText = 'Menghapus...';
                        }
                        
                        button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ${loadingText}`;
                    });
                });
            });

            // Prevent double click on PDF exports and display loading state temporarily
            const pdfLinks = document.querySelectorAll('a[href*="/pdf"]');
            pdfLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const originalHtml = link.innerHTML;
                    link.classList.add('disabled');
                    link.style.pointerEvents = 'none';
                    link.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Export PDF...`;
                    
                    setTimeout(() => {
                        link.classList.remove('disabled');
                        link.style.pointerEvents = 'auto';
                        link.innerHTML = originalHtml;
                    }, 3000);
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
