@extends('layouts.app')

@section('title', 'Detail AI Tool')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ai-tools.index') }}" class="text-decoration-none text-muted">Data AI Tools</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail AI Tool</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Detail AI Tool: {{ $aiTool->nama_ai }}</h4>
</div>

<div class="card" style="max-width: 720px;">
    <div class="card-header bg-white border-0 pt-3 d-flex align-items-center justify-content-between">
        <h6 class="card-header-title">Informasi Metadata AI</h6>
        <div>
            @if($aiTool->status === 'aktif')
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Aktif</span>
            @else
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Nonaktif</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <tbody>
                <tr>
                    <th style="width: 200px;" class="bg-light fw-bold text-secondary">Nama AI Tools</th>
                    <td class="fw-bold fs-6">{{ $aiTool->nama_ai }}</td>
                </tr>
                <tr>
                    <th class="bg-light fw-bold text-secondary">Developer / Vendor</th>
                    <td>{{ $aiTool->developer }}</td>
                </tr>
                <tr>
                    <th class="bg-light fw-bold text-secondary">Kategori Spesialisasi</th>
                    <td>{{ $aiTool->kategori }}</td>
                </tr>
                <tr>
                    <th class="bg-light fw-bold text-secondary">Website Resmi</th>
                    <td>
                        @if($aiTool->website)
                            <a href="{{ $aiTool->website }}" target="_blank" class="text-decoration-none text-primary">
                                {{ $aiTool->website }} <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.7rem;"></i>
                            </a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="bg-light fw-bold text-secondary">Deskripsi Kapabilitas</th>
                    <td>
                        @if($aiTool->deskripsi)
                            <p class="mb-0 text-secondary" style="line-height: 1.6;">{{ $aiTool->deskripsi }}</p>
                        @else
                            <span class="text-muted">Tidak ada deskripsi yang tersedia.</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('ai-tools.edit', $aiTool->id) }}" class="btn btn-sm btn-primary rounded-2 px-4">
                <i class="bi bi-pencil-fill me-1" style="font-size: 0.75rem;"></i> Edit Data
            </a>
            <a href="{{ route('ai-tools.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
