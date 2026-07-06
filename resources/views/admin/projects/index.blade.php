@extends('layouts.app')

@section('title', 'Penilaian Proyek')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Penilaian Proyek</li>
            </ol>
        </nav>
        <h4 class="mb-0 fw-bold">Inisialisasi Penilaian Proyek</h4>
    </div>
    <a href="{{ route('projects.create') }}" class="btn btn-sm btn-primary rounded-2 px-3">
        <i class="bi bi-plus-lg me-1"></i> Inisialisasi Proyek Baru
    </a>
</div>

<div class="card">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <h6 class="card-header-title">Daftar Proyek Kreatif</h6>
        <form action="{{ route('projects.index') }}" method="GET" class="d-flex gap-2" style="max-width: 320px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari proyek, client, jenis..." value="{{ $search }}">
            </div>
            @if($search)
                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-light border"><i class="bi bi-x-lg"></i></a>
            @endif
        </form>
    </div>
    
    <div class="card-body p-0">
        @if($projects->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th>Nama Proyek</th>
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                                <th>Pemilik Project</th>
                            @endif
                            <th>Client / Mitra</th>
                            <th>Jenis Pekerjaan</th>
                            <th style="width: 140px;">Tanggal</th>
                            <th style="width: 120px;">Status</th>
                            <th class="pe-4 text-end" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $index => $project)
                            <tr>
                                <td class="ps-4 text-muted">{{ $projects->firstItem() + $index }}</td>
                                <td class="fw-bold text-dark">{{ $project->nama_proyek }}</td>
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                                    <td class="fw-semibold text-secondary" style="font-size: 0.82rem;">{{ $project->owner ? $project->owner->name : 'System' }}</td>
                                @endif
                                <td>{{ $project->client }}</td>
                                <td>
                                    <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.72rem;">
                                        {{ $project->projectType->nama_proyek }}
                                    </span>
                                </td>
                                <td class="text-secondary" style="font-size: 0.78rem;">{{ \Carbon\Carbon::parse($project->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>
                                    @if($project->status === 'Draft')
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Draft</span>
                                    @elseif($project->status === 'Dinilai')
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Dinilai</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Selesai</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-light border px-2 rounded-2" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-light border px-2 rounded-2 text-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="delete-form d-inline-block">
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
                    Menampilkan {{ $projects->firstItem() }} - {{ $projects->lastItem() }} dari {{ $projects->total() }} data
                </span>
                <div>
                    {{ $projects->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="fs-1 text-muted mb-3"><i class="bi bi-folder-fill"></i></div>
                <h6 class="fw-bold mb-1">Belum Ada Proyek Kreatif</h6>
                <p class="text-muted mb-3" style="font-size: 0.75rem;">Mulai dengan menambahkan proyek baru untuk memproses kecerdasan buatan ideal.</p>
                @if($search)
                    <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">Bersihkan Pencarian</a>
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
                text: "Proyek beserta riwayat perhitungan TOPSIS terkait akan dihapus secara permanen!",
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
