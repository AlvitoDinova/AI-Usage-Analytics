@extends('layouts.app')

@section('title', 'Detail Riwayat Evaluasi')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('history.index') }}" class="text-decoration-none text-muted">Riwayat Evaluasi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Evaluasi</li>
        </ol>
    </nav>
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="mb-0 fw-bold">Detail Riwayat Evaluasi</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('history.pdf', $assessment->id) }}" class="btn btn-sm btn-danger px-3 rounded-2" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
            </a>
            <a href="{{ route('history.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Project Highlight and Summary -->
    <div class="col-12 col-lg-4">
        <!-- Best AI Tool Card -->
        <div class="card bg-primary text-white border-0 shadow-sm overflow-hidden position-relative mb-4">
            <div class="position-absolute end-0 bottom-0 opacity-10" style="font-size: 10rem; transform: translate(20%, 20%);">
                <i class="bi bi-trophy-fill"></i>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between" style="min-height: 220px; z-index: 2;">
                <div>
                    <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-3" style="font-size: 0.7rem; border-radius: 20px;">AI TERBAIK</span>
                    @if($bestAi && $bestAi->aiTool)
                        <h2 class="fw-bold mb-2">{{ $bestAi->aiTool->nama_ai }}</h2>
                        <p class="text-white-50 small mb-0 leading-relaxed" style="font-size: 0.82rem;">
                            {{ $bestAi->aiTool->deskripsi }}
                        </p>
                    @else
                        <h2 class="fw-bold mb-2">-</h2>
                        <p class="text-white-50 small mb-0">-</p>
                    @endif
                </div>
                
                <div class="mt-4 pt-3 border-top border-white-10">
                    <div class="row">
                        <div class="col-6 border-end border-white-10">
                            <span class="small text-white-50 d-block mb-1">Nilai Preferensi</span>
                            <h4 class="fw-bold mb-0 text-white">{{ number_format($bestAi ? $bestAi->nilai_preferensi : 0.0, 6) }}</h4>
                        </div>
                        <div class="col-6 ps-3">
                            <span class="small text-white-50 d-block mb-1">Tanggal Evaluasi</span>
                            <h6 class="fw-semibold mb-0 mt-1 text-white">
                                {{ \Carbon\Carbon::parse($assessment->tanggal_penilaian)->translatedFormat('d M Y') }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Metadata Card -->
        <div class="card">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="card-header-title">Informasi Proyek</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="text-secondary small d-block">Nama Proyek</span>
                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $project->nama_proyek }}</span>
                </div>
                <div class="mb-3">
                    <span class="text-secondary small d-block">Nama Client</span>
                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $project->client }}</span>
                </div>
                <div class="mb-3">
                    <span class="text-secondary small d-block">Jenis Proyek</span>
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 mt-1">{{ $project->projectType->nama_proyek }}</span>
                </div>
                <div class="mb-0">
                    <span class="text-secondary small d-block">Deskripsi Proyek</span>
                    <p class="text-secondary small mb-0 leading-relaxed">{{ $project->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Details: Criteria Weights & Recommendation Summary -->
    <div class="col-12 col-lg-8">
        <!-- Conclusion Panel -->
        <div class="card border-primary-subtle bg-primary-subtle bg-opacity-10 mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="fs-4 text-primary"><i class="bi bi-info-circle-fill"></i></div>
                    <h5 class="fw-bold text-primary mb-0">KESIMPULAN EVALUASI</h5>
                </div>
                <p class="text-dark leading-relaxed mb-0" style="font-size: 0.88rem;">
                    {{ $conclusion }}
                </p>
            </div>
        </div>

        <!-- Weight details -->
        <div class="card mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="card-header-title">Bobot Prioritas Kriteria Evaluasi</h6>
            </div>
            <div class="card-body">
                <p class="text-secondary small mb-3">Berikut adalah bobot prioritas kriteria (skala 1-5) yang digunakan saat sesi penilaian proyek ini dijalankan:</p>
                <div class="row g-2">
                    @foreach($assessment->details as $det)
                        <div class="col-6 col-md-4">
                            <div class="p-2 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                                <div class="text-truncate me-2" title="{{ $det->criterion->nama_kriteria }}">
                                    <span class="badge bg-primary text-white me-1" style="font-size: 0.65rem;">{{ $det->criterion->kode }}</span>
                                    <span class="small fw-semibold text-secondary">{{ $det->criterion->nama_kriteria }}</span>
                                </div>
                                <span class="fw-bold text-primary" style="font-size: 0.95rem;">{{ $det->bobot }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Ranks table -->
        <div class="card">
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <h6 class="card-header-title">Hasil Perankingan Alternatif AI</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center" style="width: 80px;">Rank</th>
                                <th>Alternatif AI Tool</th>
                                <th>Developer / Pengembang</th>
                                <th>Deskripsi Fungsionalitas</th>
                                <th class="text-end pe-4" style="width: 220px;">Nilai Preferensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $res)
                                <tr class="{{ $res->ranking == 1 ? 'table-success-light' : '' }}">
                                    <td class="text-center">
                                        @if($res->ranking == 1)
                                            <span class="badge bg-warning text-dark border border-warning-subtle px-2 py-1"><i class="bi bi-trophy-fill me-1"></i>1</span>
                                        @elseif($res->ranking == 2)
                                            <span class="badge bg-secondary text-white px-2 py-1">2</span>
                                        @elseif($res->ranking == 3)
                                            <span class="badge bg-danger-subtle text-danger border px-2 py-1">3</span>
                                        @else
                                            <span class="text-muted fw-semibold">{{ $res->ranking }}</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-dark">
                                        {{ $res->aiTool->nama_ai }}
                                    </td>
                                    <td class="text-secondary small">{{ $res->aiTool->developer }}</td>
                                    <td class="text-secondary small leading-relaxed" style="font-size: 0.78rem;">{{ $res->aiTool->deskripsi }}</td>
                                    <td class="text-end fw-bold text-primary pe-4" style="font-family: monospace; font-size: 0.95rem;">
                                        {{ number_format($res->nilai_preferensi, 6) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
