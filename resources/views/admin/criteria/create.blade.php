@extends('layouts.app')

@section('title', 'Tambah Kriteria')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('criteria.index') }}" class="text-decoration-none text-muted">Data Kriteria</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Kriteria</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Tambah Kriteria Baru</h4>
</div>

<div class="card" style="max-width: 640px;">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="card-header-title">Form Input Kriteria TOPSIS</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('criteria.store') }}" method="POST" novalidate>
            @csrf
            
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <label for="kode" class="form-label fw-bold">Kode Kriteria <span class="text-danger">*</span></label>
                    <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}" placeholder="Cth: K1" required>
                    @error('kode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-8 mb-3">
                    <label for="nama_kriteria" class="form-label fw-bold">Nama Kriteria <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kriteria" id="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror" value="{{ old('nama_kriteria') }}" placeholder="Cth: Kemudahan Penggunaan" required>
                    @error('nama_kriteria')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="tipe" class="form-label fw-bold">Tipe / Jenis Kriteria <span class="text-danger">*</span></label>
                <select name="tipe" id="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih tipe kriteria...</option>
                    <option value="Benefit" {{ old('tipe') === 'Benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                    <option value="Cost" {{ old('tipe') === 'Cost' ? 'selected' : '' }}>Cost (Semakin kecil semakin baik)</option>
                </select>
                @error('tipe')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi Kriteria</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Jelaskan mengenai maksud dan cakupan kriteria ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Kriteria</button>
                <a href="{{ route('criteria.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
