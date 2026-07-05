@extends('layouts.app')

@section('title', 'Inisialisasi Proyek')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none text-muted">Penilaian Proyek</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inisialisasi Proyek</li>
        </ol>
    </nav>
    <h4 class="mb-0 fw-bold">Inisialisasi Proyek Baru</h4>
</div>

<div class="card" style="max-width: 720px;">
    <div class="card-header bg-white border-0 pt-3">
        <h6 class="card-header-title">Form Data Proyek Agensi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('projects.store') }}" method="POST" novalidate>
            @csrf
            
            <div class="row">
                <div class="col-12 col-md-8 mb-3">
                    <label for="nama_proyek" class="form-label fw-bold">Nama Proyek <span class="text-danger">*</span></label>
                    <input type="text" name="nama_proyek" id="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror" value="{{ old('nama_proyek') }}" placeholder="Cth: Rebranding Website Notch Creative" required>
                    @error('nama_proyek')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label for="tanggal" class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="client" class="form-label fw-bold">Nama Client / Mitra <span class="text-danger">*</span></label>
                    <input type="text" name="client" id="client" class="form-control @error('client') is-invalid @enderror" value="{{ old('client') }}" placeholder="Cth: PT Notch Indonesia" required>
                    @error('client')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="project_type_id" class="form-label fw-bold">Jenis Proyek Kreatif <span class="text-danger">*</span></label>
                    <select name="project_type_id" id="project_type_id" class="form-select @error('project_type_id') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih jenis pekerjaan...</option>
                        @foreach($projectTypes as $type)
                            <option value="{{ $type->id }}" {{ old('project_type_id') == $type->id ? 'selected' : '' }}>{{ $type->nama_proyek }}</option>
                        @endforeach
                    </select>
                    @error('project_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Dynamic AI Tools Area -->
            <div class="mb-4 d-none" id="ai-tools-section">
                <div class="card bg-light border-light-subtle">
                    <div class="card-body p-3">
                        <label class="form-label fw-bold text-dark mb-1">Alternatif AI untuk Proyek Ini <span class="text-danger">*</span></label>
                        <div class="text-secondary small mb-3" style="font-size: 0.75rem;">Daftar AI ini dimuat otomatis berdasarkan jenis proyek kreatif. Anda dapat menghapus AI yang tidak diinginkan atau menambahkan AI lainnya.</div>
                        
                        <div class="row g-2 mb-3" id="ai-checkboxes-container">
                            <!-- Checkboxes loaded via AJAX -->
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <select id="add-other-ai" class="form-select form-select-sm">
                                    <option value="" selected disabled>+ Tambah Alternatif AI Lain...</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="alert alert-danger border-0 p-2 small mt-2 d-none" id="ai-tools-validation-error">
                            <i class="bi bi-x-circle-fill me-2"></i> Pilih setidaknya 2 alternatif AI untuk proyek ini agar perhitungan TOPSIS dapat dijalankan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-bold">Deskripsi Ringkas Proyek</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Tulis rincian singkat kebutuhan proyek untuk memudahkan evaluasi...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label fw-bold">Status Awal <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="Draft" {{ old('status') === 'Draft' ? 'selected' : '' }}>Draft (Baru diinisialisasi)</option>
                    <option value="Dinilai" {{ old('status') === 'Dinilai' ? 'selected' : '' }}>Dinilai (Siap Hitung TOPSIS)</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary rounded-2 px-4">Simpan Proyek</button>
                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const projectTypeSelect = document.getElementById('project_type_id');
    const aiToolsSection = document.getElementById('ai-tools-section');
    const aiCheckboxesContainer = document.getElementById('ai-checkboxes-container');
    const addOtherAiSelect = document.getElementById('add-other-ai');
    const validationError = document.getElementById('ai-tools-validation-error');
    const form = projectTypeSelect.closest('form');

    let allAiTools = [];
    let selectedAiIds = new Set();

    async function loadAiTools(projectTypeId) {
        if (!projectTypeId) {
            aiToolsSection.classList.add('d-none');
            return;
        }

        try {
            const response = await fetch(`/project-types/${projectTypeId}/ai-tools`);
            const data = await response.json();

            allAiTools = data.all;
            const mappedTools = data.mapped;

            // Clear previous states
            aiCheckboxesContainer.innerHTML = '';
            selectedAiIds.clear();

            if (mappedTools.length === 0) {
                aiCheckboxesContainer.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-warning border-0 py-2 small mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Belum ada AI yang dipetakan secara global untuk jenis proyek ini. Silakan gunakan menu pilihan di bawah untuk menambahkan AI secara manual.
                        </div>
                    </div>
                `;
            } else {
                mappedTools.forEach(ai => {
                    addAiCheckbox(ai);
                });
            }

            aiToolsSection.classList.remove('d-none');
            updateAddDropdown();

        } catch (error) {
            console.error('Error loading AI Tools:', error);
        }
    }

    function addAiCheckbox(ai) {
        selectedAiIds.add(ai.id);
        
        const cardHtml = `
            <div class="col-12 col-md-6 ai-checkbox-card" id="ai-card-${ai.id}">
                <div class="card border border-light-subtle h-100 bg-white shadow-sm">
                    <div class="card-body p-3 d-flex align-items-start gap-2">
                        <input class="form-check-input mt-1 ai-cb" type="checkbox" name="ai_tools[]" value="${ai.id}" id="ai_cb_${ai.id}" checked>
                        <div class="flex-grow-1">
                            <label class="form-check-label fw-bold text-dark d-block mb-0" style="font-size: 0.82rem;" for="ai_cb_${ai.id}">${ai.nama_ai}</label>
                            <span class="text-muted d-block" style="font-size: 0.68rem;">Developer: ${ai.developer}</span>
                            <span class="badge bg-secondary-subtle text-secondary px-2 py-0.5 mt-1" style="font-size: 0.65rem;">${ai.kategori}</span>
                        </div>
                    </div>
                </div>
            </div>
        `;
        aiCheckboxesContainer.insertAdjacentHTML('beforeend', cardHtml);

        // Bind listener to the new checkbox to update selectedAiIds set
        const checkbox = document.getElementById(`ai_cb_${ai.id}`);
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedAiIds.add(ai.id);
            } else {
                selectedAiIds.delete(ai.id);
            }
            updateAddDropdown();
        });
    }

    function updateAddDropdown() {
        // Clear all except placeholder
        addOtherAiSelect.innerHTML = '<option value="" selected disabled>+ Tambah Alternatif AI Lain...</option>';
        
        allAiTools.forEach(ai => {
            if (!selectedAiIds.has(ai.id)) {
                const opt = document.createElement('option');
                opt.value = ai.id;
                opt.textContent = `${ai.nama_ai} (${ai.kategori})`;
                addOtherAiSelect.appendChild(opt);
            }
        });
    }

    // Add selected tool from dropdown
    addOtherAiSelect.addEventListener('change', function() {
        const aiId = parseInt(this.value);
        if (!aiId) return;

        const ai = allAiTools.find(a => a.id === aiId);
        if (ai) {
            // Remove the empty alert if present
            const warningAlert = aiCheckboxesContainer.querySelector('.alert');
            if (warningAlert) {
                warningAlert.closest('.col-12').remove();
            }

            addAiCheckbox(ai);
            updateAddDropdown();
        }
    });

    // Handle project type dropdown change
    projectTypeSelect.addEventListener('change', function() {
        loadAiTools(this.value);
    });

    // If type is already selected (e.g. redirect back on validation errors)
    if (projectTypeSelect.value) {
        loadAiTools(projectTypeSelect.value);
    }

    // Form client-side validation
    form.addEventListener('submit', function(e) {
        const checkedCount = aiCheckboxesContainer.querySelectorAll('.ai-cb:checked').length;
        if (projectTypeSelect.value && checkedCount < 2) {
            e.preventDefault();
            validationError.classList.remove('d-none');
            validationError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            validationError.classList.add('d-none');
        }
    });
});
</script>
@endsection
