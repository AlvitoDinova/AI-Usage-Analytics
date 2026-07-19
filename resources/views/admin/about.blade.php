@extends('layouts.app')

@section('title', 'Tentang Sistem')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tentang Sistem</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Tentang Sistem AInsight</h4>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-header bg-white border-bottom border-light-subtle py-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary border border-primary-subtle rounded-circle mb-2" style="width: 72px; height: 72px;">
                    <i class="bi bi-info-circle-fill" style="font-size: 2.2rem;"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark">AInsight</h4>
                <p class="text-secondary small mb-0">Sistem Pendukung Keputusan Pemilihan AI Tools</p>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                            <tr class="border-bottom border-light-subtle">
                                <td class="fw-bold text-secondary" style="width: 200px; font-size: 0.85rem;"><i class="bi bi-tag-fill me-2 text-primary"></i> Nama Sistem</td>
                                <td class="text-dark fw-semibold" style="font-size: 0.85rem;">AInsight</td>
                            </tr>
                            <tr class="border-bottom border-light-subtle">
                                <td class="fw-bold text-secondary" style="font-size: 0.85rem;"><i class="bi bi-git me-2 text-success"></i> Versi Aplikasi</td>
                                <td class="text-dark fw-semibold" style="font-size: 0.85rem;"><span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">Version 1.0</span></td>
                            </tr>
                            <tr class="border-bottom border-light-subtle">
                                <td class="fw-bold text-secondary" style="font-size: 0.85rem;"><i class="bi bi-calculator-fill me-2 text-warning"></i> Metode SPK</td>
                                <td class="text-dark fw-semibold" style="font-size: 0.85rem;">
                                    <div>TOPSIS</div>
                                    <small class="text-muted fw-normal" style="font-size: 0.78rem;">Technique for Order Preference by Similarity to Ideal Solution</small>
                                </td>
                            </tr>
                            <tr class="border-bottom border-light-subtle">
                                <td class="fw-bold text-secondary" style="font-size: 0.85rem;"><i class="bi bi-building-fill me-2 text-info"></i> Studi Kasus</td>
                                <td class="text-dark fw-semibold" style="font-size: 0.85rem;">Notch Creative Agency</td>
                            </tr>
                            <tr class="border-bottom border-light-subtle">
                                <td class="fw-bold text-secondary" style="font-size: 0.85rem;"><i class="bi bi-terminal-fill me-2 text-dark"></i> Developer</td>
                                <td class="text-dark fw-semibold" style="font-size: 0.85rem;">{{ config('app.name') }} Developer Team</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-secondary" style="font-size: 0.85rem;"><i class="bi bi-calendar-check-fill me-2 text-danger"></i> Tahun Rilis</td>
                                <td class="text-dark fw-semibold" style="font-size: 0.85rem;">2026</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr class="border-light-subtle my-4">

                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-book-fill me-1 text-primary"></i> Deskripsi Singkat</h6>
                <p class="text-secondary leading-relaxed mb-0" style="font-size: 0.82rem; text-align: justify;">
                    AInsight dibangun khusus untuk memfasilitasi Notch Creative Agency dalam memilih alternatif software kecerdasan buatan (AI Tools) yang paling optimal sesuai dengan spesifikasi and kebutuhan parameter setiap jenis proyek kreatif. Dengan mengimplementasikan metode TOPSIS, sistem membandingkan alternatif berdasarkan kedekatan geometris terhadap solusi ideal positif dan terjauh dari solusi ideal negatif, memberikan rekomendasi keputusan yang objektif, transparan, dan dapat dipertanggungjawabkan secara matematis.
                </p>
            </div>
            <div class="card-footer bg-light border-0 py-3 text-center">
                <span class="text-muted small">AInsight &copy; 2026. All Rights Reserved.</span>
            </div>
        </div>
    </div>
</div>
@endsection
