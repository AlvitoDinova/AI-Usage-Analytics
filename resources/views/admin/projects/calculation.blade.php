@extends('layouts.app')

@section('title', 'Detail Perhitungan TOPSIS')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none text-muted">Penilaian Proyek</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.results', $project->id) }}" class="text-decoration-none text-muted">Hasil Evaluasi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Perhitungan</li>
        </ol>
    </nav>
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="mb-0 fw-bold">Detail Perhitungan TOPSIS: {{ $project->nama_proyek }}</h4>
        <a href="{{ route('projects.results', $project->id) }}" class="btn btn-sm btn-light border px-3 rounded-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Rekomendasi
        </a>
    </div>
</div>

@if(empty($logs))
    <div class="alert alert-warning border border-warning-subtle rounded-3 p-5 text-center">
        <i class="bi bi-exclamation-triangle text-warning display-4 mb-3 d-block"></i>
        <h5 class="fw-bold text-dark">Detail Perhitungan Tidak Tersedia</h5>
        <p class="text-secondary small mb-4">Detail perhitungan matematika desimal belum terbuat. Silakan jalankan proses perhitungan TOPSIS terlebih dahulu.</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-primary px-4 rounded-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Proyek
            </a>
        </div>
    </div>
@else
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body p-3 bg-light rounded-3 border">
            <ul class="nav nav-pills flex-column flex-sm-row gap-2" id="topsisTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active btn-sm text-start text-sm-center" id="matrix-tab" data-bs-toggle="tab" data-bs-target="#matrix" type="button" role="tab" aria-controls="matrix" aria-selected="true">
                        A. Matriks Keputusan Awal
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-start text-sm-center" id="norm-tab" data-bs-toggle="tab" data-bs-target="#norm" type="button" role="tab" aria-controls="norm" aria-selected="false">
                        B. Normalisasi Matriks
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-start text-sm-center" id="weighted-tab" data-bs-toggle="tab" data-bs-target="#weighted" type="button" role="tab" aria-controls="weighted" aria-selected="false">
                        C. Matriks Ternormalisasi Berbobot
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-start text-sm-center" id="ideal-tab" data-bs-toggle="tab" data-bs-target="#ideal" type="button" role="tab" aria-controls="ideal" aria-selected="false">
                        D-E. Solusi Ideal Positif dan Negatif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn-sm text-start text-sm-center" id="final-tab" data-bs-toggle="tab" data-bs-target="#final" type="button" role="tab" aria-controls="final" aria-selected="false">
                        F-H. Jarak dan Nilai Preferensi
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="topsisTabContent">
        <!-- A. Decision Matrix -->
        <div class="tab-pane fade show active" id="matrix" role="tabpanel" aria-labelledby="matrix-tab">
            <div class="card">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="card-header-title">A. Matriks Keputusan Awal</h6>
                    <p class="text-secondary small mb-0">Nilai kinerja alternatif AI terhadap masing-masing kriteria (skala 1-5).</p>
                </div>
                <div class="card-body p-0">
                    @php
                        $xData = $logs['Matriks Keputusan'] ?? [];
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.78rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-start ps-3" style="width: 150px;">Alternatif AI</th>
                                    @foreach($criteria as $c)
                                        <th title="{{ $c->nama_kriteria }}">{{ $c->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aiTools as $ai)
                                    <tr>
                                        <td class="text-start ps-3 fw-semibold text-dark">{{ $ai->nama_ai }}</td>
                                        @foreach($criteria as $c)
                                            <td>{{ $xData[$ai->id][$c->id] ?? '-' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- B. Normalization Matrix -->
        <div class="tab-pane fade" id="norm" role="tabpanel" aria-labelledby="norm-tab">
            <div class="card">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="card-header-title">B. Normalisasi Matriks</h6>
                    <p class="text-secondary small mb-0">Proses pembagian nilai kinerja alternatif dengan akar jumlah kuadrat kriteria.</p>
                </div>
                <div class="card-body p-0">
                    @php
                        $rData = $logs['Normalisasi'] ?? [];
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.78rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-start ps-3" style="width: 150px;">Alternatif AI</th>
                                    @foreach($criteria as $c)
                                        <th title="{{ $c->nama_kriteria }}">{{ $c->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aiTools as $ai)
                                    <tr>
                                        <td class="text-start ps-3 fw-semibold text-dark">{{ $ai->nama_ai }}</td>
                                        @foreach($criteria as $c)
                                            <td style="font-family: monospace;">
                                                {{ isset($rData[$ai->id][$c->id]) ? number_format($rData[$ai->id][$c->id], 6) : '-' }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- C. Weighted Matrix -->
        <div class="tab-pane fade" id="weighted" role="tabpanel" aria-labelledby="weighted-tab">
            <div class="card">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="card-header-title">C. Matriks Ternormalisasi Berbobot</h6>
                    <p class="text-secondary small mb-0">Proses perkalian matriks ternormalisasi dengan bobot kepentingan kriteria.</p>
                </div>
                <div class="card-body p-0">
                    @php
                        $yData = $logs['Matriks Terbobot'] ?? [];
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.78rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-start ps-3" style="width: 150px;">Alternatif AI</th>
                                    @foreach($criteria as $c)
                                        <th title="{{ $c->nama_kriteria }}">{{ $c->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aiTools as $ai)
                                    <tr>
                                        <td class="text-start ps-3 fw-semibold text-dark">{{ $ai->nama_ai }}</td>
                                        @foreach($criteria as $c)
                                            <td style="font-family: monospace;" class="text-primary font-semibold">
                                                {{ isset($yData[$ai->id][$c->id]) ? number_format($yData[$ai->id][$c->id], 6) : '-' }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- D-E. Ideal Solutions -->
        <div class="tab-pane fade" id="ideal" role="tabpanel" aria-labelledby="ideal-tab">
            <div class="card">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="card-header-title">D & E. Solusi Ideal Positif dan Negatif</h6>
                    <p class="text-secondary small mb-0">Nilai terbaik (maksimum untuk Benefit, minimum untuk Cost) dan terburuk untuk setiap kriteria.</p>
                </div>
                <div class="card-body p-0">
                    @php
                        $aPlus = $logs['Solusi Ideal Positif'] ?? [];
                        $aMinus = $logs['Solusi Ideal Negatif'] ?? [];
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.78rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-start ps-3">Tipe Solusi Ideal</th>
                                    @foreach($criteria as $c)
                                        <th title="{{ $c->nama_kriteria }}">{{ $c->kode }} <br> <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.6rem;">{{ $c->tipe }}</span></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start ps-3 fw-bold text-success"><i class="bi bi-plus-circle-fill me-1"></i>Solusi Ideal Positif</td>
                                    @foreach($criteria as $c)
                                        <td class="font-monospace text-success fw-bold">
                                            {{ isset($aPlus[$c->id]) ? number_format($aPlus[$c->id], 6) : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="text-start ps-3 fw-bold text-danger"><i class="bi bi-dash-circle-fill me-1"></i>Solusi Ideal Negatif</td>
                                    @foreach($criteria as $c)
                                        <td class="font-monospace text-danger fw-bold">
                                            {{ isset($aMinus[$c->id]) ? number_format($aMinus[$c->id], 6) : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- F-H. Distance & Preference -->
        <div class="tab-pane fade" id="final" role="tabpanel" aria-labelledby="final-tab">
            <div class="card">
                <div class="card-header bg-white border-0 pt-3">
                    <h6 class="card-header-title">F, G & H. Perhitungan Jarak, Nilai Preferensi, dan Peringkat Alternatif AI</h6>
                    <p class="text-secondary small mb-0">Perhitungan kedekatan relatif setiap alternatif terhadap solusi ideal.</p>
                </div>
                <div class="card-body p-0">
                    @php
                        $dPlus = $logs['Jarak Positif'] ?? [];
                        $dMinus = $logs['Jarak Negatif'] ?? [];
                        $cPref = $logs['Nilai Preferensi'] ?? [];
                        
                        // Sort by preference value descending
                        arsort($cPref);
                        $rank = 1;
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width: 100px;">Rank</th>
                                    <th>Alternatif AI Tool</th>
                                    <th class="text-center">Jarak ke Solusi Ideal Positif</th>
                                    <th class="text-center">Jarak ke Solusi Ideal Negatif</th>
                                    <th class="text-end pe-4" style="width: 200px;">Nilai Preferensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cPref as $aiId => $prefVal)
                                    @php
                                        $aiTool = $aiTools->firstWhere('id', $aiId);
                                    @endphp
                                    @if($aiTool)
                                        <tr class="{{ $rank == 1 ? 'table-success-light' : '' }}">
                                            <td class="text-center">
                                                @if($rank == 1)
                                                    <span class="badge bg-warning text-dark border border-warning-subtle px-2 py-1"><i class="bi bi-trophy-fill me-1"></i>1</span>
                                                @else
                                                    <span class="text-muted fw-semibold">{{ $rank }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $aiTool->nama_ai }}</td>
                                            <td class="text-center font-monospace">{{ number_format($dPlus[$aiId] ?? 0.0, 6) }}</td>
                                            <td class="text-center font-monospace">{{ number_format($dMinus[$aiId] ?? 0.0, 6) }}</td>
                                            <td class="text-end fw-bold text-primary font-monospace pe-4" style="font-size: 0.95rem;">
                                                {{ number_format($prefVal, 6) }}
                                            </td>
                                        </tr>
                                        @php $rank++; @endphp
                                    @endif
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
