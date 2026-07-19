@extends('layouts.app')

@section('title', 'Data AI Tools')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data AI Tools</li>
            </ol>
        </nav>
        <h4 class="mb-0 fw-bold">Daftar AI Tools</h4>
    </div>
    <a href="{{ route('ai-tools.create') }}" class="btn btn-sm btn-primary rounded-2 px-3">
        <i class="bi bi-plus-lg me-1"></i> Tambah AI Tool
    </a>
</div>

<div class="card">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h6 class="card-header-title">Alternatif AI</h6>
        <form action="{{ route('ai-tools.index') }}" method="GET" class="d-flex gap-2" style="max-width: 320px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari AI, kategori, vendor..." value="{{ $search }}">
            </div>
            @if($search)
                <a href="{{ route('ai-tools.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($aiTools->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th>Nama AI</th>
                            <th>Kategori</th>
                            <th>Developer / Vendor</th>
                            <th>Website</th>
                            <th style="width: 100px;">Status</th>
                            <th class="pe-4 text-end" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aiTools as $index => $ai)
                            <tr>
                                <td class="ps-4 text-muted">{{ $aiTools->firstItem() + $index }}</td>
                                <td class="fw-bold">{{ $ai->nama_ai }}</td>
                                <td>{{ $ai->kategori }}</td>
                                <td>{{ $ai->developer }}</td>
                                <td>
                                    @if($ai->website)
                                        <a href="{{ $ai->website }}" target="_blank" class="text-decoration-none text-primary" style="font-size: 0.78rem;">
                                            {{ Str::limit(str_replace(['https://', 'http://'], '', $ai->website), 25) }} <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.65rem;"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ai->status === 'aktif')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Aktif</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('ai-tools.show', $ai->id) }}" class="btn btn-sm btn-light border px-2 rounded-2" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('ai-tools.edit', $ai->id) }}" class="btn btn-sm btn-light border px-2 rounded-2 text-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('ai-tools.destroy', $ai->id) }}" method="POST" class="delete-form d-inline-block">
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
                    Menampilkan {{ $aiTools->firstItem() }} - {{ $aiTools->lastItem() }} dari {{ $aiTools->total() }} data
                </span>
                <div>
                    {{ $aiTools->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="fs-1 text-muted mb-3"><i class="bi bi-robot"></i></div>
                <h6 class="fw-bold mb-1">Tidak Ada Data AI Tools</h6>
                <p class="text-muted mb-3" style="font-size: 0.75rem;">Silakan tambahkan data AI Tool baru menggunakan tombol di bawah ini.</p>
                @if(!$search)
                    <a href="{{ route('ai-tools.create') }}" class="btn btn-sm btn-primary px-3 rounded-2">
                        <i class="bi bi-plus-lg me-1"></i> Tambah AI Tool
                    </a>
                @else
                    <a href="{{ route('ai-tools.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">Bersihkan Pencarian</a>
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
                text: "Data AI Tool ini akan dihapus secara permanen dari database!",
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
