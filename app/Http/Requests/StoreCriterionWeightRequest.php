<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriterionWeightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weights' => 'required|array',
            'weights.*' => 'required|integer|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'weights.*.required' => 'Nilai bobot wajib diisi.',
            'weights.*.integer' => 'Nilai bobot harus berupa angka.',
            'weights.*.min' => 'Bobot minimal adalah 0%.',
            'weights.*.max' => 'Bobot maksimal adalah 100%.',
        ];
    }
}
