@extends('layouts.app')

@section('title', 'Riwayat Evaluasi - Coming Soon')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="text-center p-5 bg-white border border-light-subtle rounded-4 shadow-sm" style="max-width: 540px;">
        <div class="display-1 text-primary mb-4">
            <i class="bi bi-clock-history"></i>
        </div>
        <h3 class="fw-bold mb-2">Riwayat Evaluasi</h3>
        <p class="text-secondary leading-relaxed mb-4" style="font-size: 0.88rem;">
            Modul Riwayat Evaluasi dan Laporan Perhitungan TOPSIS akan diimplementasikan secara penuh pada **Sprint 6 & Sprint 7** sesuai dokumen Development Plan.
        </p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary px-4 rounded-2">Kembali ke Dashboard</a>
            <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-2">Lihat Proyek</a>
        </div>
    </div>
</div>
@endsection
