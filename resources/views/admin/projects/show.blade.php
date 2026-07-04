@extends('layouts.app')

@section('title', 'Detail Proyek')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none text-muted">Penilaian Proyek</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Proyek</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Detail Proyek: {{ $project->nama_proyek }}</h4>
</div>

<div class="row g-4">
    <!-- Project info -->
    <div class="col-12 col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="card-header-title">Detail Informasi Proyek</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush" style="font-size: 0.82rem;">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
                        <span class="text-muted">Nama Proyek</span>
                        <strong class="text-end">{{ $project->nama_proyek }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
                        <span class="text-muted">Client / Mitra</span>
                        <strong class="text-end">{{ $project->client }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
                        <span class="text-muted">Jenis Pekerjaan</span>
                        <strong class="text-end">{{ $project->projectType->nama_proyek }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
                        <span class="text-muted">Tanggal Inisialisasi</span>
                        <strong class="text-end">{{ \Carbon\Carbon::parse($project->tanggal)->translatedFormat('d F Y') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-0">
                        <span class="text-muted">Status</span>
                        @if($project->status === 'Draft')
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Draft</span>
                        @elseif($project->status === 'Dinilai')
                            <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Dinilai</span>
                        @else
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Selesai</span>
                        @endif
                    </li>
                </ul>

                @if($project->deskripsi)
                    <div class="mt-3 p-3 bg-light rounded-3 border border-light-subtle">
                        <h6 class="fw-bold mb-1" style="font-size: 0.78rem;">Deskripsi:</h6>
                        <p class="mb-0 text-secondary" style="font-size: 0.78rem; line-height: 1.5;">{{ $project->deskripsi }}</p>
                    </div>
                @endif

                <div class="mt-4">
                    @if($project->status === 'Selesai')
                        <a href="{{ route('projects.results', $project->id) }}" class="btn btn-sm btn-success rounded-2 px-3 w-100 mb-2 py-2">
                            <i class="bi bi-award-fill me-1"></i> Lihat Hasil Evaluasi
                        </a>
                    @else
                        <form action="{{ route('projects.calculate', $project->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary rounded-2 px-3 w-100 py-2 fw-semibold">
                                <i class="bi bi-cpu-fill me-1"></i> Proses TOPSIS
                            </button>
                        </form>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-outline-warning rounded-2 px-3 flex-grow-1">
                            <i class="bi bi-pencil-fill me-1" style="font-size: 0.75rem;"></i> Edit Proyek
                        </a>
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-light border rounded-2 px-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Read-only Decision Matrix view -->
    <div class="col-12 col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center justify-content-between">
                <h6 class="card-header-title">Matriks Keputusan Global (X)</h6>
                <a href="{{ route('matrix.index', ['project_id' => $project->id]) }}" class="btn btn-sm btn-outline-primary px-3 rounded-2">
                    <i class="bi bi-grid-3x3-gap-fill me-1"></i> Edit Matriks
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.78rem;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 140px;" class="text-start ps-3 bg-light">Alternatif AI</th>
                                @foreach($criteria as $c)
                                    <th title="{{ $c->nama_kriteria }}">{{ $c->kode }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aiTools as $ai)
                                <tr>
                                    <td class="text-start ps-3 fw-bold bg-light">{{ $ai->nama_ai }}</td>
                                    @foreach($criteria as $c)
                                        @php
                                            $val = 0;
                                            if (isset($matrixScores[$ai->id])) {
                                                $match = $matrixScores[$ai->id]->firstWhere('criteria_id', $c->id);
                                                $val = $match ? $match->nilai : 0;
                                            }
                                        @endphp
                                        <td>{{ $val ?: '—' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top text-muted" style="font-size: 0.7rem;">
                    * Keterangan Kode Kriteria: @foreach($criteria as $c) <strong>{{ $c->kode }}</strong>: {{ $c->nama_kriteria }} ({{ $c->tipe }})@if(!$loop->last), @endif @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
