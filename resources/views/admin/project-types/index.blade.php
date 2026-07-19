@extends('layouts.app')

@section('title', 'Jenis Proyek')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Jenis Proyek</li>
            </ol>
        </nav>
        <h4 class="mb-0 fw-bold">Daftar Jenis Proyek Kreatif</h4>
    </div>
    <a href="{{ route('project-types.create') }}" class="btn btn-sm btn-primary rounded-2 px-3">
        <i class="bi bi-plus-lg me-1"></i> Tambah Jenis Proyek
    </a>
</div>

<!-- Custom Error Alert for Foreign Key restriction -->
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="bi bi-x-circle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card" style="max-width: 720px;">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h6 class="card-header-title">Kategori Pekerjaan Agensi</h6>
        <form action="{{ route('project-types.index') }}" method="GET" class="d-flex gap-2" style="max-width: 280px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari jenis proyek..." value="{{ $search }}">
            </div>
            @if($search)
                <a href="{{ route('project-types.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($projectTypes->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 80px;">No</th>
                            <th>Nama Jenis Proyek</th>
                            <th class="pe-4 text-end" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projectTypes as $index => $type)
                            <tr>
                                <td class="ps-4 text-muted">{{ $projectTypes->firstItem() + $index }}</td>
                                <td class="fw-bold">{{ $type->nama_proyek }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('project-types.edit', $type->id) }}" class="btn btn-sm btn-light border px-2 rounded-2 text-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('project-types.destroy', $type->id) }}" method="POST" class="delete-form d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border px-2 rounded-2 text-danger delete-btn" title="Hapus">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
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
                <div class="fs-1 text-muted mb-3"><i class="bi bi-folder-fill"></i></div>
                <h6 class="fw-bold mb-1">Tidak Ada Data Jenis Proyek</h6>
                <p class="text-muted mb-3" style="font-size: 0.75rem;">Silakan tambahkan data jenis proyek baru menggunakan tombol di bawah ini.</p>
                @if(!$search)
                    <a href="{{ route('project-types.create') }}" class="btn btn-sm btn-primary px-3 rounded-2">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Jenis Proyek
                    </a>
                @else
                    <a href="{{ route('project-types.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">Bersihkan Pencarian</a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // SweetAlert2 Delete Confirmation
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data jenis proyek ini akan dihapus secara permanen dari database!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
