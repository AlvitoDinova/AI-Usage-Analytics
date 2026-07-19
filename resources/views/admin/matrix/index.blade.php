@extends('layouts.app')

@section('title', 'Matriks Keputusan')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Matriks Keputusan</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Matriks Keputusan Global (X)</h4>
</div>

<!-- Warning / Error Alerts -->
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card mb-4">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="card-header-title">Pilih Proyek Penilaian</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('matrix.index') }}" method="GET" class="row g-3 align-items-end" id="project-select-form">
            <div class="col-12 col-md-8">
                <label for="project_id" class="form-label fw-bold" style="font-size: 0.8rem;">Proyek Kreatif</label>
                <select name="project_id" id="project_id" class="form-select" onchange="document.getElementById('project-select-form').submit();">
                    <option value="">-- Pilih Proyek Agensi --</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}" {{ $selectedProjectId == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_proyek }} (Client: {{ $p->client }} | Status: {{ $p->status }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-4">
                <noscript>
                    <button type="submit" class="btn btn-sm btn-primary w-100 rounded-2">Pilih Proyek</button>
                </noscript>
            </div>
        </form>
    </div>
</div>

@if($selectedProject)
    <div class="card">
        <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center justify-content-between">
            <div>
                <h6 class="card-header-title mb-0">Edit Nilai Kinerja Alternatif AI</h6>
                <small class="text-muted" style="font-size: 0.72rem;">Proyek Terpilih: <strong>{{ $selectedProject->nama_proyek }}</strong> | Status: <strong>{{ $selectedProject->status }}</strong></small>
            </div>
            <span class="badge bg-primary-subtle text-primary border px-2 py-1" style="font-size: 0.7rem;">Skala 1-5</span>
        </div>
        
        <div class="card-body p-0">
            <form action="{{ route('matrix.store') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.8rem;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 160px;" class="text-start ps-3">Alternatif AI</th>
                                @foreach($criteria as $c)
                                    <th title="{{ $c->nama_kriteria }}" style="min-width: 90px;">
                                        {{ $c->kode }}
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">({{ $c->tipe === 'Benefit' ? 'B' : 'C' }})</small>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aiTools as $ai)
                                <tr>
                                    <td class="text-start ps-3 fw-bold bg-light">{{ $ai->nama_ai }}</td>
                                    @foreach($criteria as $c)
                                        @php
                                            $val = 3; // default
                                            if (isset($matrixScores[$ai->id])) {
                                                $match = $matrixScores[$ai->id]->firstWhere('criteria_id', $c->id);
                                                $val = $match ? $match->nilai : 3;
                                            }
                                            $oldVal = old("scores.{$ai->id}.{$c->id}", $val);
                                        @endphp
                                        <td>
                                            <select name="scores[{{ $ai->id }}][{{ $c->id }}]" class="form-select form-select-sm text-center" style="font-size: 0.78rem;" required>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ $oldVal == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="p-3 border-top d-flex align-items-center justify-content-between">
                    <div class="text-muted" style="font-size: 0.72rem;">
                        * Simpan akan otomatis merubah status proyek menjadi <strong>Dinilai</strong>.
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('projects.show', $selectedProject->id) }}" class="btn btn-sm btn-outline-secondary rounded-2">
                            <i class="bi bi-arrow-left-short"></i> Kembali ke Detail Project
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Matriks Keputusan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h6 class="fw-bold mb-2" style="font-size: 0.8rem;">Kamus Kriteria Penilaian:</h6>
            <div class="row g-2">
                @foreach($criteria as $c)
                    <div class="col-12 col-md-6 col-lg-4" style="font-size: 0.75rem;">
                        <strong>{{ $c->kode }} - {{ $c->nama_kriteria }}</strong> ({{ $c->tipe }})
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <div class="fs-1 text-muted mb-3"><i class="bi bi-info-circle-fill"></i></div>
            <h6 class="fw-bold mb-1">Pilih Proyek Terlebih Dahulu</h6>
            <p class="text-muted mb-0" style="font-size: 0.75rem;">Silakan pilih salah satu proyek kreatif pada dropdown di atas untuk mengedit matriks keputusan.</p>
        </div>
    </div>
@endif
@endsection
