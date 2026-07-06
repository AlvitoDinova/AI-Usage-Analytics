<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        $user = $this->route('user');
        $userId = $user instanceof \App\Models\User ? $user->id : $user;

        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:admin,manager,employee'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh melebihi 150 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh melebihi 150 karakter.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Pilihan status tidak valid.',
        ];
    }
}
