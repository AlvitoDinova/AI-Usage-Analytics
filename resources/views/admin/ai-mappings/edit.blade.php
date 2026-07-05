@extends('layouts.app')

@section('title', 'Edit AI Mapping')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ai-mappings.index') }}" class="text-decoration-none text-muted">AI Mapping</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Mapping</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Edit Pemetaan AI: {{ $projectType->nama_proyek }}</h4>
</div>

<div class="card" style="max-width: 900px;">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center justify-content-between">
        <h6 class="card-header-title">Form Pemetaan Alternatif AI</h6>
        <div class="text-muted small">Pilih AI yang relevan untuk jenis pekerjaan ini.</div>
    </div>
    <div class="card-body">
        <form action="{{ route('ai-mappings.update', $projectType->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4 p-3 bg-light rounded-3 border">
                <span class="text-muted small d-block mb-1">Jenis Proyek Kreatif</span>
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-folder-fill text-primary me-2"></i>{{ $projectType->nama_proyek }}</h5>
            </div>

            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <label class="form-label fw-bold mb-0">Pilih Alternatif AI Tools <span class="text-danger">*</span></label>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-xs btn-outline-secondary py-1 px-2 rounded-2" style="font-size: 0.72rem;" id="select-all">Pilih Semua</button>
                        <button type="button" class="btn btn-xs btn-outline-secondary py-1 px-2 rounded-2" style="font-size: 0.72rem;" id="deselect-all">Kosongkan</button>
                    </div>
                </div>

                @if($aiTools->count() > 0)
                    <div class="row g-3">
                        @foreach($aiTools as $ai)
                            <div class="col-12 col-md-6">
                                <label class="card h-100 cursor-pointer border-light-subtle shadow-sm transition-all duration-200 card-hover" style="cursor: pointer;" for="ai_tool_{{ $ai->id }}">
                                    <div class="card-body p-3 d-flex align-items-start gap-3">
                                        <div class="form-check-wrapper mt-1">
                                            <input class="form-check-input ai-checkbox" type="checkbox" name="ai_tools[]" value="{{ $ai->id }}" id="ai_tool_{{ $ai->id }}" {{ in_array($ai->id, $mappedAiIds) ? 'checked' : '' }}>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $ai->nama_ai }}</span>
                                                <span class="badge bg-secondary-subtle text-secondary px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">{{ $ai->kategori }}</span>
                                            </div>
                                            <span class="text-muted d-block small mb-2" style="font-size: 0.72rem;">Developer: {{ $ai->developer }}</span>
                                            <p class="text-secondary mb-0 leading-relaxed" style="font-size: 0.75rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">
                                                {{ $ai->deskripsi ?: 'Tidak ada deskripsi.' }}
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-warning border-0 p-4 text-center">
                        <i class="bi bi-robot text-warning display-5 mb-2 d-block"></i>
                        <h6 class="fw-bold text-dark">Data AI Tools Kosong</h6>
                        <p class="text-muted small mb-0">Silakan tambahkan data AI Tools aktif di menu Data AI Tools terlebih dahulu.</p>
                    </div>
                @endif
            </div>

            <div class="d-flex gap-2 pt-3 border-top">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Pemetaan</button>
                <a href="{{ route('ai-mappings.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('select-all').addEventListener('click', function() {
        document.querySelectorAll('.ai-checkbox').forEach(cb => cb.checked = true);
    });

    document.getElementById('deselect-all').addEventListener('click', function() {
        document.querySelectorAll('.ai-checkbox').forEach(cb => cb.checked = false);
    });
</script>
@endsection
