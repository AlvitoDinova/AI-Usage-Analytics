@extends('layouts.app')

@section('title', 'Tambah Jenis Proyek')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('project-types.index') }}" class="text-decoration-none text-muted">Jenis Proyek</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Jenis Proyek</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Tambah Jenis Proyek Baru</h4>
</div>

<div class="card" style="max-width: 560px;">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="card-header-title">Form Input Kategori Proyek</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('project-types.store') }}" method="POST" novalidate>
            @csrf
            
            <div class="mb-4">
                <label for="nama_proyek" class="form-label fw-bold">Nama Kategori Jenis Proyek <span class="text-danger">*</span></label>
                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}" placeholder="Cth: Social Media Content, Motion Graphic" required>
                @error('nama_proyek')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Kategori</button>
                <a href="{{ route('project-types.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
