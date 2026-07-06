@extends('layouts.app')

@section('title', 'Ubah Data User')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none text-muted">Manajemen User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah User</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Ubah Data User: {{ $user->name }}</h4>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="card-header-title">Form Ubah Data Pengguna</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            
            <!-- Name field -->
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Cth: Alvito Dinova" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email field -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email Korporat <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Cth: alvito@notchcreative.com" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password field -->
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Kata Sandi Baru</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Biarkan kosong jika tidak ingin mengubah kata sandi">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Role field -->
            <div class="mb-3">
                <label for="role" class="form-label fw-bold">Hak Akses (Role) <span class="text-danger">*</span></label>
                @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <select class="form-select" disabled>
                        <option selected>{{ ucfirst($user->role) }} (Anda sedang masuk dengan akun ini)</option>
                    </select>
                    <div class="text-secondary small mt-1" style="font-size: 0.72rem;">Anda tidak dapat mengubah role Anda sendiri untuk menghindari lockout.</div>
                @else
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh)</option>
                        <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Manager (Evaluasi & Statistik)</option>
                        <option value="employee" {{ old('role', $user->role) === 'employee' ? 'selected' : '' }}>Employee (Pembuat Proyek & Input Matriks)</option>
                    </select>
                @endif
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status field -->
            <div class="mb-4">
                <label for="status" class="form-label fw-bold">Status Akun <span class="text-danger">*</span></label>
                @if($user->id === auth()->id())
                    <input type="hidden" name="status" value="{{ $user->status }}">
                    <select class="form-select" disabled>
                        <option selected>Aktif (Anda sedang masuk dengan akun ini)</option>
                    </select>
                    <div class="text-secondary small mt-1" style="font-size: 0.72rem;">Anda tidak dapat menonaktifkan akun Anda sendiri.</div>
                @else
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Aktif (Dapat Login)</option>
                        <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Nonaktif (Akses Diblokir)</option>
                    </select>
                @endif
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
