@extends('layouts.app')

@section('title', 'Dashboard Employee')

@section('content')
<!-- Welcome Card -->
<div class="card bg-white border border-light-subtle rounded-3 p-4 mb-4 shadow-sm">
    <div class="d-flex align-items-center gap-3">
        <div class="brand-logo-container bg-primary-subtle text-primary border border-primary-subtle d-inline-flex align-items-center justify-content-center" style="width: 54px; height: 54px; border-radius: 12px;">
            <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
        </div>
        <div>
            <h4 class="mb-0 fw-bold">Halo, {{ $user->name }}!</h4>
            <p class="text-secondary mb-0 small">Selamat datang kembali di AInsight. Mari selesaikan penilaian alternatif AI Anda hari ini.</p>
        </div>
    </div>
</div>

<!-- Employee Widgets -->
<div class="row g-4 mb-4">
    <!-- Total Personal Projects -->
    <div class="col-12 col-md-4">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Project Saya</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_projects'] }}</h3>
                </div>
                <div class="metric-icon-box bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-folder-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Personal Projects -->
    <div class="col-12 col-md-4">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Project Selesai</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['completed_projects'] }}</h3>
                </div>
                <div class="metric-icon-box bg-success-subtle text-success border border-success-subtle">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Personal Projects -->
    <div class="col-12 col-md-4">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Menunggu Penilaian</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['pending_projects'] }}</h3>
                </div>
                <div class="metric-icon-box bg-warning-subtle text-warning border border-warning-subtle">
                    <i class="bi bi-clock-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Shortcuts Card -->
<div class="card shadow-sm mb-4">
    <div class="card-body p-4 text-center text-md-start">
        <h5 class="fw-bold mb-3">Tindakan Cepat</h5>
        <div class="d-flex flex-column flex-md-row gap-3">
            <a href="{{ route('projects.index') }}" class="btn btn-primary px-4 py-2 rounded-2 fw-semibold">
                <i class="bi bi-arrow-right-circle me-1"></i> Lanjutkan Penilaian Proyek
            </a>
            <a href="{{ route('history.index') }}" class="btn btn-outline-success px-4 py-2 rounded-2 fw-semibold">
                <i class="bi bi-clock-history me-1"></i> Lihat History Saya
            </a>
        </div>
    </div>
</div>
@endsection
