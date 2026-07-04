@extends('layouts.app')

@section('title', 'Edit AI Tool')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ai-tools.index') }}" class="text-decoration-none text-muted">Data AI Tools</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit AI Tool</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Edit AI Tool: {{ $aiTool->nama_ai }}</h4>
</div>

<div class="card" style="max-width: 720px;">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="card-header-title">Form Ubah Data AI</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('ai-tools.update', $aiTool->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nama_ai" class="form-label fw-bold">Nama AI Tools <span class="text-danger">*</span></label>
                <input type="text" name="nama_ai" id="nama_ai" class="form-control @error('nama_ai') is-invalid @enderror" value="{{ old('nama_ai', $aiTool->nama_ai) }}" required>
                @error('nama_ai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="developer" class="form-label fw-bold">Developer / Vendor <span class="text-danger">*</span></label>
                    <input type="text" name="developer" id="developer" class="form-control @error('developer') is-invalid @enderror" value="{{ old('developer', $aiTool->developer) }}" required>
                    @error('developer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="kategori" class="form-label fw-bold">Kategori AI <span class="text-danger">*</span></label>
                    <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $aiTool->kategori) }}" required>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="website" class="form-label fw-bold">Alamat Website URL</label>
                <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $aiTool->website) }}">
                @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $aiTool->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-bold">Status Keaktifan <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="aktif" {{ old('status', $aiTool->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $aiTool->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Perubahan</button>
                <a href="{{ route('ai-tools.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
