@extends('layouts.app')

@section('title', 'Dashboard Manager')

@section('content')
<div class="mb-4">
    <h4 class="mb-0 fw-bold">Dashboard Pengawasan Manager</h4>
    <p class="text-secondary small">Pantau log penilaian, hasil keputusan rekomendasi, dan performa alternatif kecerdasan buatan.</p>
</div>

<!-- Manager Widgets -->
<div class="row g-4 mb-4">
    <!-- Total Projects -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Jumlah Proyek</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_proyek'] }}</h3>
                </div>
                <div class="metric-icon-box bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-folder-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User Aktif -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">User Aktif</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_user_aktif'] }}</h3>
                </div>
                <div class="metric-icon-box bg-info-subtle text-info border border-info-subtle">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Draft -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Project Draft</h6>
                    <h3 class="mb-0 fw-bold text-secondary">{{ $stats['total_draft_proyek'] }}</h3>
                </div>
                <div class="metric-icon-box bg-secondary-subtle text-secondary border border-secondary-subtle">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Evaluations -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Evaluasi Selesai</h6>
                    <h3 class="mb-0 fw-bold text-success">{{ $stats['total_evaluasi'] }}</h3>
                </div>
                <div class="metric-icon-box bg-success-subtle text-success border border-success-subtle">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Last Evaluated Project -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Proyek Terakhir</h6>
                    <h5 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 140px;" title="{{ $stats['proyek_terakhir_dievaluasi'] }}">
                        {{ $stats['proyek_terakhir_dievaluasi'] }}
                    </h5>
                </div>
                <div class="metric-icon-box bg-warning-subtle text-warning border border-warning-subtle">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Last Best AI -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">AI Terbaik Terakhir</h6>
                    <h5 class="mb-0 fw-bold text-success text-truncate" style="max-width: 140px;" title="{{ $stats['ai_terbaik_terakhir'] }}">
                        {{ $stats['ai_terbaik_terakhir'] }}
                    </h5>
                </div>
                <div class="metric-icon-box bg-success-subtle text-success border border-success-subtle">
                    <i class="bi bi-award-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluasi Bulan Ini -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Evaluasi Bulan Ini</h6>
                    <h3 class="mb-0 fw-bold text-primary">{{ $stats['evaluasi_bulan_ini'] }}</h3>
                </div>
                <div class="metric-icon-box bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Terpopuler Rank 1 -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">AI Terfavorit (#1)</h6>
                    <h5 class="mb-0 fw-bold text-warning text-truncate" style="max-width: 140px;" title="{{ $stats['ai_terfavorit'] }}">
                        {{ $stats['ai_terfavorit'] }}
                    </h5>
                </div>
                <div class="metric-icon-box bg-warning-subtle text-warning border border-warning-subtle">
                    <i class="bi bi-trophy-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shortcuts Card -->
<div class="card shadow-sm mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Akses Cepat Pengawasan</h5>
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <a href="{{ route('projects.index') }}" class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between text-decoration-none text-dark card-hover w-100">
                    <div>
                        <h6 class="mb-0 fw-bold">Lihat Proyek</h6>
                        <span class="text-secondary small" style="font-size: 0.72rem;">Daftar & status pengerjaan proyek</span>
                    </div>
                    <i class="bi bi-arrow-right-circle-fill text-primary display-6"></i>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('history.index') }}" class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between text-decoration-none text-dark card-hover w-100">
                    <div>
                        <h6 class="mb-0 fw-bold">Riwayat Evaluasi</h6>
                        <span class="text-secondary small" style="font-size: 0.72rem;">Buka hasil kalkulasi TOPSIS & PDF</span>
                    </div>
                    <i class="bi bi-arrow-right-circle-fill text-success display-6"></i>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('statistics.index') }}" class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between text-decoration-none text-dark card-hover w-100">
                    <div>
                        <h6 class="mb-0 fw-bold">Statistik SPK</h6>
                        <span class="text-secondary small" style="font-size: 0.72rem;">Analisis grafik keterpilihan AI</span>
                    </div>
                    <i class="bi bi-arrow-right-circle-fill text-warning display-6"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
