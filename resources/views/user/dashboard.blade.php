@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total AI Tools Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">Total AI Tools</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_ai_tools'] }}</h3>
                </div>
                <div class="metric-icon-box bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-robot"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kriteria Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">Total Kriteria</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_kriteria'] }}</h3>
                </div>
                <div class="metric-icon-box bg-success-subtle text-success border border-success-subtle">
                    <i class="bi bi-list-stars"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Proyek Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">Total Proyek</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_proyek'] }}</h3>
                </div>
                <div class="metric-icon-box bg-warning-subtle text-warning border border-warning-subtle">
                    <i class="bi bi-folder-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User Aktif Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">User Aktif</h6>
                    <h3 class="mb-0 fw-bold text-dark">{{ $stats['total_user_aktif'] }}</h3>
                </div>
                <div class="metric-icon-box bg-info-subtle text-info border border-info-subtle">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Project Draft Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">Project Draft</h6>
                    <h3 class="mb-0 fw-bold text-secondary">{{ $stats['total_draft_proyek'] }}</h3>
                </div>
                <div class="metric-icon-box bg-secondary-subtle text-secondary border border-secondary-subtle">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Selesai Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">Project Selesai</h6>
                    <h3 class="mb-0 fw-bold text-success">{{ $stats['total_evaluasi'] }}</h3>
                </div>
                <div class="metric-icon-box bg-success-subtle text-success border border-success-subtle">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluasi Bulan Ini Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">Evaluasi Bulan Ini</h6>
                    <h3 class="mb-0 fw-bold text-primary">{{ $stats['evaluasi_bulan_ini'] }}</h3>
                </div>
                <div class="metric-icon-box bg-primary-subtle text-primary border border-primary-subtle">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Terfavorit Card -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card card-hover h-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="card-header-title mb-2">AI Terfavorit (#1)</h6>
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

<!-- TOPSIS Pipeline Visualization -->
<div class="card mb-4">
    <div class="card-header bg-white border-0 pt-3 pb-0">
        <h6 class="card-header-title">Alur Proses Perhitungan SPK TOPSIS</h6>
    </div>
    <div class="card-body pt-2">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                    <span class="badge bg-primary rounded-circle mb-2" style="width: 24px; height: 24px; padding: 5px;">1</span>
                    <p class="mb-0 fw-semibold text-wrap" style="font-size: 0.75rem;">Matriks Keputusan (X)</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                    <span class="badge bg-primary rounded-circle mb-2" style="width: 24px; height: 24px; padding: 5px;">2</span>
                    <p class="mb-0 fw-semibold text-wrap" style="font-size: 0.75rem;">Normalisasi Matriks (R)</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                    <span class="badge bg-primary rounded-circle mb-2" style="width: 24px; height: 24px; padding: 5px;">3</span>
                    <p class="mb-0 fw-semibold text-wrap" style="font-size: 0.75rem;">Matriks Terbobot (Y)</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                    <span class="badge bg-primary rounded-circle mb-2" style="width: 24px; height: 24px; padding: 5px;">4</span>
                    <p class="mb-0 fw-semibold text-wrap" style="font-size: 0.75rem;">Solusi Ideal (A+/A-)</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                    <span class="badge bg-primary rounded-circle mb-2" style="width: 24px; height: 24px; padding: 5px;">5</span>
                    <p class="mb-0 fw-semibold text-wrap" style="font-size: 0.75rem;">Jarak Solusi (D+/D-)</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                    <span class="badge bg-primary rounded-circle mb-2" style="width: 24px; height: 24px; padding: 5px;">6</span>
                    <p class="mb-0 fw-semibold text-wrap" style="font-size: 0.75rem;">Nilai Preferensi (Ci*)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Top 5 AI tools ranked 1 -->
    <div class="col-12 col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="card-header-title">Top 5 AI Terpopuler (Rekomendasi Terbaik)</h6>
            </div>
            <div class="card-body">
                <p class="text-secondary small mb-3">AI alternatif yang paling sering memperoleh Peringkat 1 (nilai preferensi tertinggi) di seluruh penilaian proyek:</p>
                @if($top5Ai->isEmpty())
                    <div class="text-center p-4">
                        <i class="bi bi-award-fill text-muted display-6 d-block mb-2"></i>
                        <p class="text-secondary small">Belum ada alternatif yang mencapai peringkat 1.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.82rem;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Alternatif AI Tool</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Rekomendasi #1</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rank = 1; @endphp
                                @foreach($top5Ai as $item)
                                    <tr>
                                        <td>
                                            @if($rank == 1)
                                                <span class="badge bg-warning text-dark border border-warning-subtle"><i class="bi bi-trophy-fill me-1"></i>1</span>
                                            @elseif($rank == 2)
                                                <span class="badge bg-secondary text-white">2</span>
                                            @elseif($rank == 3)
                                                <span class="badge bg-danger-subtle text-danger border">3</span>
                                            @else
                                                <span class="text-muted fw-semibold ps-1">{{ $rank }}</span>
                                            @endif
                                            @php $rank++; @endphp
                                        </td>
                                        <td class="fw-bold text-dark">{{ $item->aiTool->nama_ai }}</td>
                                        <td class="text-secondary small">{{ $item->aiTool->kategori }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 fw-bold">
                                                {{ $item->total_rank1 }} Kali
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

    <!-- Quick Actions and Info column -->
    <div class="col-12 col-lg-6 d-flex flex-column gap-4">
        <!-- Quick Actions -->
        <div class="card flex-grow-1">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="card-header-title">Aksi Cepat Sistem</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 border border-light-subtle">
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-4 text-primary"><i class="bi bi-play-circle-fill"></i></div>
                            <div>
                                <h6 class="mb-1 fw-bold" style="font-size: 0.8rem;">Mulai Penilaian Proyek Baru</h6>
                                <p class="text-muted mb-0" style="font-size: 0.72rem;">Evaluasi dan cari rekomendasi AI terbaik untuk proyek agensi.</p>
                            </div>
                        </div>
                        <a href="{{ route('projects.create') }}" class="btn btn-sm btn-primary px-3 rounded-2">Mulai</a>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 border border-light-subtle">
                        <div class="d-flex align-items-center gap-3">
                            <div class="fs-4 text-success"><i class="bi bi-journal-check"></i></div>
                            <div>
                                <h6 class="mb-1 fw-bold" style="font-size: 0.8rem;">Lihat Riwayat Evaluasi</h6>
                                <p class="text-muted mb-0" style="font-size: 0.72rem;">Tinjau dan cetak laporan hasil perhitungan TOPSIS sebelumnya.</p>
                            </div>
                        </div>
                        <a href="{{ route('history.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">Riwayat</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notch Creative Agency Info -->
        <div class="card flex-grow-1">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="card-header-title">Tentang AInsight</h6>
            </div>
            <div class="card-body py-2">
                <p class="text-secondary leading-relaxed mb-2" style="font-size: 0.8rem;">
                    AInsight adalah aplikasi Sistem Pendukung Keputusan (SPK) yang dirancang khusus untuk mempermudah pemilihan software kecerdasan buatan (AI Tools) di <strong>Notch Creative Agency</strong>. 
                </p>
                <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.8rem;">
                    Dengan membandingkan parameter spesifik seperti tingkat akurasi, kemudahan operasional, penanganan Bahasa Indonesia, integrasi sistem, dan harga lisensi berlangganan menggunakan metode matematika <strong>TOPSIS</strong>, sistem ini menyajikan alternatif terbaik berdasarkan kecocokan ideal positif dan negatif dari karakteristik setiap proyek kreatif.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
