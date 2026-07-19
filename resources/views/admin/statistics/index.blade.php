@extends('layouts.app')

@section('title', 'Statistik SPK')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Statistik</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Analisis & Statistik SPK</h4>
</div>

<!-- KPI Cards Row -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Total Proyek</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $totalProjects }}</h3>
                </div>
                <div class="metric-icon-box bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-folder-fill"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Total Alternatif AI</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $totalAi }}</h3>
                </div>
                <div class="metric-icon-box bg-success-subtle text-success border border-success-subtle">
                    <i class="bi bi-robot"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Total Evaluasi TOPSIS</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $totalEvaluations }}</h3>
                </div>
                <div class="metric-icon-box bg-warning-subtle text-warning border border-warning-subtle">
                    <i class="bi bi-calculator-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 shadow-sm border-0 bg-white card-hover">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-secondary small fw-bold mb-1">Rata-rata AI / Proyek</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ number_format($avgAi, 1) }}</h3>
                </div>
                <div class="metric-icon-box bg-info-subtle text-info border border-info-subtle">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Top AI Tools Ranked 1 -->
    <div class="col-12 col-xl-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h6 class="card-header-title mb-2">AI Terpopuler (Peringkat 1 TOPSIS)</h6>
                <p class="text-secondary small mb-3">Frekuensi alternatif AI terpilih sebagai peringkat pertama (rekomendasi terbaik) dalam seluruh sesi perhitungan TOPSIS:</p>
                @if($aiRank1Counts->isEmpty())
                    <div class="text-center p-4">
                        <i class="bi bi-award-fill text-muted display-6 d-block mb-2"></i>
                        <p class="text-secondary small">Belum ada alternatif yang mencapai peringkat 1.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 50px;">Rank</th>
                                    <th>Nama AI Tool</th>
                                    <th>Kategori</th>
                                    <th class="text-center" style="width: 130px;">Jumlah Rekomendasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rank = 1; @endphp
                                @foreach($aiRank1Counts as $item)
                                    <tr>
                                        <td>
                                            @if($rank == 1)
                                                <span class="badge bg-warning text-dark border border-warning-subtle px-2"><i class="bi bi-trophy-fill me-1"></i>1</span>
                                            @elseif($rank == 2)
                                                <span class="badge bg-secondary text-white px-2">2</span>
                                            @elseif($rank == 3)
                                                <span class="badge bg-danger-subtle text-danger border px-2">3</span>
                                            @else
                                                <span class="text-muted fw-semibold ps-1">{{ $rank }}</span>
                                            @endif
                                            @php $rank++; @endphp
                                        </td>
                                        <td class="fw-bold text-dark">{{ $item->aiTool->nama_ai }}</td>
                                        <td class="text-secondary small">{{ $item->aiTool->kategori }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 fw-bold" style="font-size: 0.78rem;">
                                                {{ $item->count }} Kali
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- AI Participation Frequency -->
    <div class="col-12 col-xl-6">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h6 class="card-header-title mb-2">Keikutsertaan Evaluasi per AI Tool</h6>
                <p class="text-secondary small mb-3">Jumlah keikutsertaan alternatif AI dalam simulasi perankingan proyek yang telah diselesaikan:</p>
                @if($aiEvaluationCounts->isEmpty())
                    <div class="text-center p-4">
                        <i class="bi bi-activity text-muted display-6 d-block mb-2"></i>
                        <p class="text-secondary small">Belum ada log evaluasi alternatif.</p>
                    </div>
                @else
                    <div class="d-flex flex-column gap-3" style="max-height: 380px; overflow-y: auto; padding-right: 5px;">
                        @php
                            $maxEvalCount = $aiEvaluationCounts->first()->count ?? 1;
                        @endphp
                        @foreach($aiEvaluationCounts as $item)
                            @php
                                $percent = ($item->count / $maxEvalCount) * 100;
                            @endphp
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark small">{{ $item->aiTool->nama_ai }}</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold" style="font-size: 0.65rem;">
                                        {{ $item->count }} Evaluasi
                                    </span>
                                </div>
                                <div class="progress" style="height: 8px; border-radius: 4px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percent }}%; border-radius: 4px;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Project Breakdown by Category -->
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-header-title mb-2">Distribusi Kategori Jenis Pekerjaan Kreatif</h6>
                <p class="text-secondary small mb-3">Distribusi volume proyek yang didaftarkan agensi Notch Creative berdasarkan jenis pekerjaannya:</p>
                <div class="row g-3">
                    @foreach($projectsByType as $type)
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between card-hover h-100">
                                <div class="pe-2">
                                    <h6 class="mb-1 fw-bold text-dark">{{ $type->nama_proyek }}</h6>
                                    <span class="text-secondary d-block" style="font-size: 0.68rem;">Jenis Kategori</span>
                                </div>
                                <div class="text-end flex-shrink-0">
                                    <h4 class="mb-0 fw-bold text-primary">{{ $type->projects_count }}</h4>
                                    <span class="text-muted d-block" style="font-size: 0.62rem;">Proyek</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
