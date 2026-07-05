<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_proyek' => 'required|string|max:255',
            'client' => 'required|string|max:150',
            'project_type_id' => 'required|exists:project_types,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Draft,Dinilai,Selesai',
            'deskripsi' => 'nullable|string',
            'ai_tools' => 'required|array|min:2',
            'ai_tools.*' => 'exists:ai_tools,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_proyek.required' => 'Nama proyek wajib diisi.',
            'client.required' => 'Nama client wajib diisi.',
            'project_type_id.required' => 'Kategori jenis proyek wajib dipilih.',
            'project_type_id.exists' => 'Jenis proyek terpilih tidak valid.',
            'tanggal.required' => 'Tanggal proyek wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'status.required' => 'Status proyek wajib dipilih.',
            'status.in' => 'Status proyek tidak valid.',
            'ai_tools.required' => 'Alternatif AI wajib dipilih.',
            'ai_tools.array' => 'Format alternatif AI tidak valid.',
            'ai_tools.min' => 'Pilih setidaknya 2 alternatif AI untuk proyek.',
            'ai_tools.*.exists' => 'Alternatif AI terpilih tidak valid.',
        ];
    }
}
