<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAIToolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $aiId = $this->route('ai_tool') ? $this->route('ai_tool')->id : null;

        return [
            'nama_ai' => [
                'required',
                'string',
                'max:100',
                Rule::unique('ai_tools', 'nama_ai')->ignore($aiId),
            ],
            'developer' => 'required|string|max:100',
            'kategori' => 'required|string|max:150',
            'website' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_ai.required' => 'Nama AI wajib diisi.',
            'nama_ai.unique' => 'Nama AI ini sudah terdaftar.',
            'developer.required' => 'Developer/Vendor wajib diisi.',
            'kategori.required' => 'Kategori wajib diisi.',
            'website.url' => 'Format website harus berupa URL valid (cth: https://example.com).',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
