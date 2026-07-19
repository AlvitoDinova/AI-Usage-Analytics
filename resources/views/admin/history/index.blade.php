@extends('layouts.app')

@section('title', 'Riwayat Evaluasi')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Evaluasi</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Riwayat Evaluasi TOPSIS</h4>
</div>

<!-- Filter Card -->
<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('history.index') }}" class="row g-2 align-items-end">
            <!-- Search field -->
            <div class="col-12 col-md-3">
                <label for="search" class="form-label small fw-bold text-secondary mb-1">Cari Proyek / Client</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                </div>
            </div>

            <!-- Project Type filter -->
            <div class="col-12 col-md-2">
                <label for="project_type_id" class="form-label small fw-bold text-secondary mb-1">Jenis Proyek</label>
                <select name="project_type_id" id="project_type_id" class="form-select form-select-sm">
                    <option value="">Semua Jenis</option>
                    @foreach($projectTypes as $type)
                        <option value="{{ $type->id }}" {{ request('project_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->nama_proyek }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Start Date filter -->
            <div class="col-12 col-md-2">
                <label for="start_date" class="form-label small fw-bold text-secondary mb-1">Mulai Tanggal</label>
                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}">
            </div>

            <!-- End Date filter -->
            <div class="col-12 col-md-2">
                <label for="end_date" class="form-label small fw-bold text-secondary mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}">
            </div>

            <!-- Action buttons -->
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary flex-grow-1 rounded-2">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                <a href="{{ route('history.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2" title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- History Table Card -->
<div class="card">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center justify-content-between">
        <h6 class="card-header-title">Log Hasil Penilaian Proyek</h6>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1" style="font-size: 0.68rem;">
            Total: {{ $evaluations->total() }} Evaluasi
        </span>
    </div>
    <div class="card-body p-0">
        @if($evaluations->isEmpty())
            <div class="text-center p-5">
                <i class="bi bi-journal-x text-muted display-4 d-block mb-3"></i>
                <h6 class="fw-bold text-dark mb-1">Belum Ada Riwayat Evaluasi</h6>
                <p class="text-secondary small mb-3">Data evaluasi kosong atau tidak ditemukan dengan filter saat ini.</p>
                <a href="{{ route('projects.create') }}" class="btn btn-sm btn-success px-3 rounded-2">
                    <i class="bi bi-play-circle-fill me-1"></i> Mulai Evaluasi
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 250px;">Nama Proyek / Client</th>
                            <th>Jenis Proyek</th>
                            <th>AI Terbaik (Ranking 1)</th>
                            <th class="text-center" style="width: 150px;">Nilai Preferensi</th>
                            <th style="width: 180px;">Tanggal Evaluasi</th>
                            <th class="text-end pe-3" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluations as $eval)
                            @php
                                $bestResult = $eval->topsisResults->where('ranking', 1)->first();
                            @endphp
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">{{ $eval->nama_proyek }}</div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">Client: {{ $eval->client }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                        {{ $eval->jenis_proyek }}
                                    </span>
                                </td>
                                <td>
                                    @if($bestResult && $bestResult->aiTool)
                                        <span class="fw-semibold text-success">
                                            <i class="bi bi-award-fill text-warning me-1"></i>{{ $bestResult->aiTool->nama_ai }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center fw-bold text-primary" style="font-family: monospace;">
                                    @if($bestResult)
                                        {{ number_format($bestResult->nilai_preferensi, 6) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-calendar3 text-muted me-1 small"></i>
                                    {{ \Carbon\Carbon::parse($eval->tanggal_penilaian)->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('history.show', $eval->assessment_id) }}" class="btn btn-xs btn-outline-primary px-2 py-1 rounded-2" style="font-size: 0.7rem;" title="Detail Evaluasi">
                                            <i class="bi bi-info-circle-fill"></i> Detail
                                        </a>
                                        <a href="{{ route('history.pdf', $eval->assessment_id) }}" class="btn btn-xs btn-danger px-2 py-1 rounded-2 text-white" style="font-size: 0.7rem;" title="Export PDF" target="_blank">
                                            <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($evaluations->hasPages())
                <div class="card-footer bg-white border-0 px-3 py-2 d-flex justify-content-center">
                    {{ $evaluations->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
