@extends('layouts.app')

@section('title', 'Bobot Kriteria')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bobot Kriteria</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Pengaturan Bobot Kriteria</h4>
</div>

<!-- Warning alert if not 100% -->
@if($totalWeight !== 100)
    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-3"></i>
        <div>
            <strong class="d-block">Peringatan: Konfigurasi Belum Seimbang!</strong>
            Total seluruh bobot kriteria saat ini adalah <strong class="underline">{{ $totalWeight }}%</strong>. Jumlah bobot harus tepat <strong>100%</strong> agar kalkulasi TOPSIS berjalan valid.
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-x-circle-fill fs-5 me-3"></i>
        <div>
            {{ session('warning') }}
        </div>
    </div>
@endif

<div class="card" style="max-width: 800px;">
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center justify-content-between">
        <h6 class="card-header-title">Atur Persentase Bobot Default</h6>
        <span class="badge bg-secondary-subtle text-secondary border px-2 py-1" id="total-badge" style="font-size: 0.78rem;">
            Total: <span id="total-display" class="fw-bold">{{ $totalWeight }}</span>%
        </span>
    </div>
    
    <div class="card-body">
        @if($criteria->isNotEmpty())
            <form action="{{ route('criterion-weights.store') }}" method="POST" novalidate>
                @csrf
                
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 100px;" class="text-center">Kode</th>
                                <th>Nama Kriteria</th>
                                <th style="width: 150px;">Jenis</th>
                                <th style="width: 180px;">Bobot (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($criteria as $c)
                                <tr>
                                    <td class="text-center fw-bold text-primary">{{ $c->kode }}</td>
                                    <td>{{ $c->nama_kriteria }}</td>
                                    <td>
                                        @if($c->tipe === 'Benefit')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Benefit</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 0.68rem; border-radius: 20px;">Cost</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="weights[{{ $c->id }}]" class="form-control text-center weight-input @error('weights.'.$c->id) is-invalid @enderror" 
                                                   value="{{ old('weights.' . $c->id, $c->defaultWeight ? $c->defaultWeight->bobot : 0) }}" 
                                                   min="0" max="100" required>
                                            <span class="input-group-text">%</span>
                                            @error('weights.'.$c->id)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-muted" style="font-size: 0.75rem;">
                        * Pastikan total penjumlahan seluruh kriteria adalah 100%.
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4" id="save-btn">Simpan Konfigurasi</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
                    </div>
                </div>
            </form>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="fs-1 text-muted mb-3"><i class="bi bi-percent"></i></div>
                <h6 class="fw-bold mb-1">Tidak Ada Data Kriteria</h6>
                <p class="text-muted mb-3" style="font-size: 0.75rem;">Silakan tambahkan kriteria terlebih dahulu sebelum mengatur bobot kriteria.</p>
                <a href="{{ route('criteria.create') }}" class="btn btn-sm btn-primary px-3 rounded-2">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kriteria
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Live update total weights sum in Javascript
    const inputs = document.querySelectorAll('.weight-input');
    const totalDisplay = document.getElementById('total-display');
    const totalBadge = document.getElementById('total-badge');
    const saveBtn = document.getElementById('save-btn');

    function calculateTotal() {
        let total = 0;
        inputs.forEach(input => {
            total += parseInt(input.value || 0);
        });
        
        totalDisplay.innerText = total;
        
        if (total === 100) {
            totalBadge.className = "badge bg-success-subtle text-success border border-success-subtle px-2 py-1";
            saveBtn.disabled = false;
        } else {
            totalBadge.className = "badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1";
        }
    }

    inputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    // Initial run
    calculateTotal();
</script>
@endsection
