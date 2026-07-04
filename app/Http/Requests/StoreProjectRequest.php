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
        ];
    }
}
