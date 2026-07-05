@extends('layouts.app')

@section('title', 'Hasil Rekomendasi TOPSIS')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none text-muted">Penilaian Proyek</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.show', $project->id) }}" class="text-decoration-none text-muted">Detail Proyek</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hasil Evaluasi</li>
        </ol>
    </nav>
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="mb-0 fw-bold">Hasil Rekomendasi TOPSIS</h4>
        <div class="d-flex gap-2">
            @if(!$results->isEmpty() && isset($assessment))
                <a href="{{ route('history.pdf', $assessment->id) }}" class="btn btn-sm btn-danger px-3 rounded-2" target="_blank">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export PDF
                </a>
            @endif
            <a href="{{ route('projects.calculation', $project->id) }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Detail Perhitungan
            </a>
        </div>
    </div>
</div>

@if($results->isEmpty())
    @if($assessment)
        <div class="alert alert-warning border border-warning-subtle rounded-3 p-5 text-center">
            <i class="bi bi-exclamation-triangle text-warning display-4 mb-3 d-block"></i>
            <h5 class="fw-bold text-dark">Hasil Evaluasi Belum Tersedia</h5>
            <p class="text-secondary small mb-4">Alternatif AI pada proyek telah berubah sehingga hasil evaluasi sebelumnya sudah tidak berlaku. Silakan jalankan kembali proses TOPSIS untuk memperoleh hasil terbaru.</p>
            <div class="d-flex justify-content-center gap-2 align-items-center">
                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-outline-secondary px-4 rounded-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Project
                </a>
                <form action="{{ route('projects.calculate', $project->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary px-4 rounded-2">
                        <i class="bi bi-cpu-fill me-1"></i> Proses TOPSIS
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-warning border border-warning-subtle rounded-3 p-5 text-center">
            <i class="bi bi-exclamation-triangle text-warning display-4 mb-3 d-block"></i>
            <h5 class="fw-bold text-dark">Belum Ada Hasil Evaluasi</h5>
            <p class="text-secondary small mb-4">Proyek ini belum dievaluasi menggunakan metode TOPSIS. Silakan jalankan proses perhitungan terlebih dahulu.</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-primary px-4 rounded-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Proyek
                </a>
            </div>
        </div>
    @endif
@else
    <div class="row g-4">
        <!-- Conclusion Card (FITUR 6) -->
        @if($bestAi && $bestAi->aiTool)
        <div class="col-12">
            <div class="card border-primary-subtle bg-primary-subtle bg-opacity-10 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="text-primary fs-5"><i class="bi bi-info-circle-fill"></i></div>
                        <h6 class="fw-bold text-primary mb-0" style="font-size: 0.8rem;">KESIMPULAN EVALUASI</h6>
                    </div>
                    <p class="text-dark small mb-0 leading-relaxed">
                        Berdasarkan analisis multikriteria menggunakan metode TOPSIS untuk proyek <strong>{{ $project->nama_proyek }}</strong> ({{ $project->projectType->nama_proyek }}), alternatif <strong>{{ $bestAi->aiTool->nama_ai }}</strong> terpilih sebagai rekomendasi terbaik dengan nilai preferensi tertinggi sebesar <strong>{{ number_format($bestAi->nilai_preferensi, 6) }}</strong>. Hal ini menunjukkan bahwa {{ $bestAi->aiTool->nama_ai }} memiliki tingkat kecocokan yang paling optimal terhadap pembobotan kriteria proyek yang diinput oleh user.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Highlight best AI tool -->
        <div class="col-12 col-lg-4">
            <div class="card bg-primary text-white border-0 h-100 shadow-sm overflow-hidden position-relative">
                <div class="position-absolute end-0 bottom-0 opacity-10" style="font-size: 10rem; transform: translate(20%, 20%);">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between" style="z-index: 2;">
                    <div>
                        <span class="badge bg-white text-primary fw-bold px-3 py-1 mb-3" style="font-size: 0.7rem; border-radius: 20px;">AI TERBAIK</span>
                        @if($bestAi && $bestAi->aiTool)
                            <h2 class="fw-bold mb-2">{{ $bestAi->aiTool->nama_ai }}</h2>
                            <p class="text-white-50 small mb-4 leading-relaxed" style="font-size: 0.82rem;">
                                {{ $bestAi->aiTool->deskripsi }}
                            </p>
                        @else
                            <h2 class="fw-bold mb-2">-</h2>
                            <p class="text-white-50 small mb-4">-</p>
                        @endif
                    </div>
                    
                    <div class="mt-4 pt-3 border-top border-white-10">
                        <div class="row text-center text-lg-start">
                            <div class="col-6 border-end border-white-10">
                                <span class="small text-white-50 block mb-1">Nilai Preferensi</span>
                                <h4 class="fw-bold mb-0 text-white">{{ number_format($bestAi ? $bestAi->nilai_preferensi : 0.0, 4) }}</h4>
                            </div>
                            <div class="col-6 ps-3">
                                <span class="small text-white-50 block mb-1">Tanggal Evaluasi</span>
                                <h6 class="fw-semibold mb-0 mt-1 text-white">
                                    {{ $assessment ? \Carbon\Carbon::parse($assessment->tanggal_penilaian)->translatedFormat('d M Y') : '-' }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project context -->
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="card-header-title">Informasi Proyek & Parameter Bobot</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3 pb-3 border-bottom border-light-subtle">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <span class="text-secondary small d-block">Nama Proyek / Client</span>
                            <span class="fw-bold" style="font-size: 0.95rem;">{{ $project->nama_proyek }}</span>
                            <span class="text-secondary small block d-block">{{ $project->client }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-secondary small d-block">Jenis Proyek</span>
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 mt-1">{{ $project->projectType->nama_proyek }}</span>
                        </div>
                    </div>

                    @if($assessment)
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.78rem;">Bobot Kriteria Sesi Ini:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($assessment->details as $det)
                                <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.7rem;" title="{{ $det->criterion->nama_kriteria }}">
                                    {{ $det->criterion->kode }}: <strong class="text-primary">{{ $det->bobot }}</strong>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ranking table -->
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0 pt-3 pb-2">
                    <h6 class="card-header-title">Tabel Hasil Perankingan Alternatif AI</h6>
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
@endif
@endsection
