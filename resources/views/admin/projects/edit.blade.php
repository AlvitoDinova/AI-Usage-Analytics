@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none text-muted">Penilaian Proyek</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Proyek</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Edit Proyek: {{ $project->nama_proyek }}</h4>
</div>

<div class="card" style="max-width: 720px;">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="card-header-title">Form Ubah Data Proyek</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('projects.update', $project->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-12 col-md-8 mb-3">
                    <label for="nama_proyek" class="form-label fw-bold">Nama Proyek <span class="text-danger">*</span></label>
                    <input type="text" name="nama_proyek" id="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek', $project->nama_proyek) }}" required>
                    @error('nama_proyek')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $project->tanggal) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="client" class="form-label fw-bold">Nama Client / Mitra <span class="text-danger">*</span></label>
                    <input type="text" name="client" id="client" class="form-control @error('client') is-invalid @enderror" value="{{ old('client', $project->client) }}" required>
                    @error('client')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="project_type_id" class="form-label fw-bold">Jenis Proyek Kreatif <span class="text-danger">*</span></label>
                    <select name="project_type_id" id="project_type_id" class="form-select @error('project_type_id') is-invalid @enderror" required>
                        @foreach($projectTypes as $type)
                            <option value="{{ $type->id }}" {{ old('project_type_id', $project->project_type_id) == $type->id ? 'selected' : '' }}>{{ $type->nama_proyek }}</option>
                        @endforeach
                    </select>
                    @error('project_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi Ringkas Proyek</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $project->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="Draft" {{ old('status', $project->status) === 'Draft' ? 'selected' : '' }}>Draft (Baru diinisialisasi)</option>
                    <option value="Dinilai" {{ old('status', $project->status) === 'Dinilai' ? 'selected' : '' }}>Dinilai (Siap Hitung TOPSIS)</option>
                    <option value="Selesai" {{ old('status', $project->status) === 'Selesai' ? 'selected' : '' }}>Selesai (Keputusan Diambil)</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Perubahan</button>
                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
