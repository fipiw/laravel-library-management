<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAnggotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $anggotaId = $this->route('anggota')?->id;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', Rule::unique('anggota', 'email')->ignore($anggotaId)],
            'tgl_daftar' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama anggota wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar pada anggota lain.',
        ];
    }
}
