@extends('layouts.app')

@section('title', 'AI Mapping')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item text-muted">Data Master</li>
                <li class="breadcrumb-item active" aria-current="page">AI Mapping</li>
            </ol>
        </nav>
        <h4 class="mb-0 fw-bold">Pemetaan AI ke Jenis Proyek</h4>
    </div>
</div>

<div class="card" style="max-width: 900px;">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h6 class="card-header-title">Daftar Pemetaan Alternatif AI</h6>
        <form action="{{ route('ai-mappings.index') }}" method="GET" class="d-flex gap-2" style="max-width: 320px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari jenis proyek..." value="{{ $search }}">
            </div>
            @if($search)
                <a href="{{ route('ai-mappings.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($projectTypes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" style="width: 80px;">No</th>
                            <th style="width: 250px;">Nama Jenis Proyek</th>
                            <th>AI Terpetakan</th>
                            <th class="pe-4 text-end" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projectTypes as $index => $type)
                            <tr>
                                <td class="ps-4 text-muted">{{ $projectTypes->firstItem() + $index }}</td>
                                <td class="fw-bold text-dark">{{ $type->nama_proyek }}</td>
                                <td>
                                    @if($type->aiTools->count() > 0)
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($type->aiTools as $ai)
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1" style="font-size: 0.72rem;">
                                                    {{ $ai->nama_ai }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted small italic"><i class="bi bi-exclamation-circle me-1"></i>Belum ada AI dipetakan</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('ai-mappings.edit', $type->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-2" title="Edit Pemetaan">
                                        <i class="bi bi-shuffle me-1"></i> Edit Mapping
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-4 py-3 border-top d-flex align-items-center justify-content-between">
                <span class="text-muted" style="font-size: 0.75rem;">
                    Menampilkan {{ $projectTypes->firstItem() }} - {{ $projectTypes->lastItem() }} dari {{ $projectTypes->total() }} data
                </span>
                <div>
                    {{ $projectTypes->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="fs-1 text-muted mb-3"><i class="bi bi-shuffle"></i></div>
                <h6 class="fw-bold mb-1">Tidak Ada Data Jenis Proyek</h6>
                <p class="text-muted mb-3" style="font-size: 0.75rem;">Silakan tambahkan data jenis proyek terlebih dahulu untuk mengatur pemetaan AI.</p>
                @if(!$search)
                    <a href="{{ route('project-types.create') }}" class="btn btn-sm btn-primary px-3 rounded-2">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Jenis Proyek
                    </a>
                @else
                    <a href="{{ route('ai-mappings.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">Bersihkan Pencarian</a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
