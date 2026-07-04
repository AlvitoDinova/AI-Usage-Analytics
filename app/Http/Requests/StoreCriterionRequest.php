<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCriterionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $criterionId = $this->route('criterion') ? $this->route('criterion')->id : null;

        return [
            'kode' => [
                'required',
                'string',
                'max:10',
                Rule::unique('criteria', 'kode')->ignore($criterionId),
            ],
            'nama_kriteria' => 'required|string|max:150',
            'tipe' => 'required|in:Benefit,Cost',
            'deskripsi' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode kriteria wajib diisi (cth: K1, K2).',
            'kode.unique' => 'Kode kriteria ini sudah digunakan.',
            'nama_kriteria.required' => 'Nama kriteria wajib diisi.',
            'tipe.required' => 'Tipe kriteria (Benefit atau Cost) wajib dipilih.',
            'tipe.in' => 'Tipe kriteria tidak valid.',
        ];
    }
}
