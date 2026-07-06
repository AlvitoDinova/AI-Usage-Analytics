@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manajemen User</li>
        </ol>
    </nav>
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="mb-0 fw-bold">Manajemen User</h4>
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary px-3 rounded-2">
            <i class="bi bi-plus-circle-fill me-1"></i> Tambah User
        </a>
    </div>
</div>

<!-- Filter & Search Card -->
<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('users.index') }}" class="row g-2 align-items-end">
            <div class="col-12 col-md-6 col-lg-4">
                <label for="search" class="form-label small fw-bold text-secondary mb-1">Cari Nama / Email</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Ketik nama atau email..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <button type="submit" class="btn btn-sm btn-primary w-100 rounded-2">
                    <i class="bi bi-funnel-fill me-1"></i> Cari
                </button>
            </div>
            @if($search)
                <div class="col-12 col-md-3 col-lg-2">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-light border w-100 rounded-2">
                        Reset
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>

<!-- Users Table Card -->
<div class="card">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center justify-content-between">
        <h6 class="card-header-title">Daftar Pengguna Sistem</h6>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1" style="font-size: 0.68rem;">
            Total: {{ $users->total() }} User
        </span>
    </div>
    <div class="card-body p-0">
        @if($users->isEmpty())
            <div class="text-center p-5">
                <i class="bi bi-people text-muted display-4 d-block mb-3"></i>
                <h6 class="fw-bold text-dark mb-1">Belum Ada User</h6>
                <p class="text-secondary small">Data user kosong atau tidak ditemukan dengan kata kunci pencarian Anda.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3" style="width: 50px;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Hak Akses (Role)</th>
                            <th>Status Akun</th>
                            <th class="text-end pe-3" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                            <tr>
                                <td class="ps-3 text-muted">{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $u->name }}</div>
                                </td>
                                <td>
                                    <span class="text-secondary">{{ $u->email }}</span>
                                </td>
                                <td>
                                    @if($u->role === 'admin')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.7rem; border-radius: 12px;">
                                            <i class="bi bi-shield-lock-fill me-1"></i>Admin
                                        </span>
                                    @elseif($u->role === 'manager')
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 text-dark" style="font-size: 0.7rem; border-radius: 12px;">
                                            <i class="bi bi-briefcase-fill me-1"></i>Manager
                                        </span>
                                    @else
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 text-dark" style="font-size: 0.7rem; border-radius: 12px;">
                                            <i class="bi bi-person-fill me-1"></i>Employee
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($u->status === 'active')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.7rem; border-radius: 12px;">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1" style="font-size: 0.7rem; border-radius: 12px;">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('users.edit', $u->id) }}" class="btn btn-xs btn-outline-warning px-2 py-1 rounded-2" style="font-size: 0.7rem;" title="Ubah User">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        @if($u->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-xs btn-outline-danger px-2 py-1 rounded-2 delete-btn" style="font-size: 0.7rem;" title="Hapus User">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-xs btn-outline-secondary px-2 py-1 rounded-2 disabled" style="font-size: 0.7rem;" title="Anda sedang login dengan akun ini" disabled>
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="card-footer bg-white border-0 px-3 py-2 d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Akun ini akan dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
