<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projectTypeId = $this->route('project_type') ? $this->route('project_type')->id : null;

        return [
            'nama_proyek' => [
                'required',
                'string',
                'max:100',
                Rule::unique('project_types', 'nama_proyek')->ignore($projectTypeId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_proyek.required' => 'Nama jenis proyek wajib diisi.',
            'nama_proyek.unique' => 'Nama jenis proyek ini sudah terdaftar.',
        ];
    }
}
