@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Log Aktivitas</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Log Aktivitas Sistem</h4>
</div>

<!-- Filter Card -->
<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('activity-logs.index') }}" class="row g-2 align-items-end">
            <!-- Search Text -->
            <div class="col-12 col-md-3">
                <label for="search" class="form-label small fw-bold text-secondary mb-1">Cari Aktivitas</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                </div>
            </div>

            <!-- Activity Type Dropdown -->
            <div class="col-12 col-md-2">
                <label for="activity_type" class="form-label small fw-bold text-secondary mb-1">Jenis Aktivitas</label>
                <select name="activity_type" id="activity_type" class="form-select form-select-sm">
                    <option value="">Semua Aktivitas</option>
                    <option value="project" {{ request('activity_type') == 'project' ? 'selected' : '' }}>Proyek (Create/Edit/Delete)</option>
                    <option value="ai_tool" {{ request('activity_type') == 'ai_tool' ? 'selected' : '' }}>AI Tool (Create/Edit/Delete)</option>
                    <option value="mapping" {{ request('activity_type') == 'mapping' ? 'selected' : '' }}>AI Mapping</option>
                    <option value="matrix" {{ request('activity_type') == 'matrix' ? 'selected' : '' }}>Matriks Keputusan</option>
                    <option value="topsis" {{ request('activity_type') == 'topsis' ? 'selected' : '' }}>Kalkulasi TOPSIS</option>
                    <option value="pdf" {{ request('activity_type') == 'pdf' ? 'selected' : '' }}>Ekspor PDF</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="col-12 col-md-2">
                <label for="start_date" class="form-label small fw-bold text-secondary mb-1">Mulai Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
            </div>

            <!-- End Date -->
            <div class="col-12 col-md-2">
                <label for="end_date" class="form-label small fw-bold text-secondary mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
            </div>

            <!-- Action buttons -->
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1 rounded-2">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                <a href="{{ route('activity-logs.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Logs List Card -->
<div class="card">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center justify-content-between">
        <h6 class="card-header-title">Log Riwayat Audit</h6>
        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1" style="font-size: 0.68rem;">
            Total: {{ $logs->total() }} Log
        </span>
    </div>
    <div class="card-body p-0">
        @if($logs->isEmpty())
            <div class="text-center p-5">
                <i class="bi bi-shield-slash text-muted display-4 d-block mb-3"></i>
                <h6 class="fw-bold text-dark mb-1">Tidak Ada Log Aktivitas</h6>
                <p class="text-secondary small">Log audit kosong atau tidak ditemukan dengan parameter filter saat ini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 80px;">No</th>
                            <th>Aktivitas Audit Trail</th>
                            <th style="width: 250px;">Tanggal & Waktu Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = ($logs->currentPage() - 1) * $logs->perPage() + 1;
                        @endphp
                        @foreach($logs as $log)
                            <tr>
                                <td class="ps-3 text-secondary fw-semibold">{{ $no++ }}</td>
                                <td class="text-dark">
                                    <!-- Use dynamic badges based on keywords in log text -->
                                    @if(str_contains(strtolower($log->aktivitas), 'gagal'))
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle me-1" style="font-size: 0.65rem;">Gagal</span>
                                    @elseif(str_contains(strtolower($log->aktivitas), 'topsis'))
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle me-1" style="font-size: 0.65rem;">TOPSIS</span>
                                    @elseif(str_contains(strtolower($log->aktivitas), 'hapus'))
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle me-1" style="font-size: 0.65rem;">Delete</span>
                                    @elseif(str_contains(strtolower($log->aktivitas), 'membuat') || str_contains(strtolower($log->aktivitas), 'menambahkan'))
                                        <span class="badge bg-success-subtle text-success border border-success-subtle me-1" style="font-size: 0.65rem;">Create</span>
                                    @elseif(str_contains(strtolower($log->aktivitas), 'memperbarui') || str_contains(strtolower($log->aktivitas), 'mengubah'))
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle me-1" style="font-size: 0.65rem;">Update</span>
                                    @elseif(str_contains(strtolower($log->aktivitas), 'ekspor') || str_contains(strtolower($log->aktivitas), 'pdf'))
                                        <span class="badge bg-info-subtle text-info border border-info-subtle me-1" style="font-size: 0.65rem;">Export</span>
                                    @endif
                                    
                                    {{ $log->aktivitas }}
                                </td>
                                <td>
                                    <i class="bi bi-clock-history text-muted me-1 small"></i>
                                    {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i:s') }} WIB
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
                <div class="card-footer bg-white border-0 px-3 py-2 d-flex justify-content-center">
                    {{ $logs->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
