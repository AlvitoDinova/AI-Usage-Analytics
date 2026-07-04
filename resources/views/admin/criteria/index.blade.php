@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Kriteria</li>
            </ol>
        </nav>
        <h4 class="mb-0 fw-bold">Daftar Kriteria Penilaian</h4>
    </div>
    <a href="{{ route('criteria.create') }}" class="btn btn-sm btn-primary rounded-2 px-3">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kriteria
    </a>
</div>

<div class="card">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h6 class="card-header-title">Kriteria TOPSIS</h6>
        <form action="{{ route('criteria.index') }}" method="GET" class="d-flex gap-2" style="max-width: 320px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari kode, kriteria, tipe..." value="{{ $search }}">
            </div>
            @if($search)
                <a href="{{ route('criteria.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($criteria->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 80px;">Kode</th>
                            <th>Nama Kriteria</th>
                            <th style="width: 150px;">Jenis / Tipe</th>
                            <th>Deskripsi</th>
                            <th class="pe-4 text-end" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($criteria as $c)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ $c->kode }}</td>
                                <td class="fw-bold">{{ $c->nama_kriteria }}</td>
                                <td>
                                    @if($c->tipe === 'Benefit')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Benefit</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Cost</span>
                                    @endif
                                </td>
                                <td class="text-muted" style="font-size: 0.78rem;">{{ Str::limit($c->deskripsi, 80) }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('criteria.edit', $c->id) }}" class="btn btn-sm btn-light border px-2 rounded-2 text-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('criteria.destroy', $c->id) }}" method="POST" class="delete-form d-inline-block">
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
                    Menampilkan {{ $criteria->firstItem() }} - {{ $criteria->lastItem() }} dari {{ $criteria->total() }} data
                </span>
                <div>
                    {{ $criteria->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="fs-1 text-muted mb-3"><i class="bi bi-list-stars"></i></div>
                <h6 class="fw-bold mb-1">Tidak Ada Data Kriteria</h6>
                <p class="text-muted mb-3" style="font-size: 0.75rem;">Silakan tambahkan data Kriteria baru menggunakan tombol di atas.</p>
                @if($search)
                    <a href="{{ route('criteria.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">Bersihkan Pencarian</a>
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
                text: "Data Kriteria ini akan dihapus secara permanen dari database!",
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
