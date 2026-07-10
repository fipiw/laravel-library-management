<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanRequest extends FormRequest
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
        return [
            'anggota_id' => ['required', 'exists:anggota,id'],
            'buku_id' => ['required', 'exists:buku,id'],
            'tgl_pinjam' => ['required', 'date'],
            'tgl_kembali' => ['required', 'date', 'after_or_equal:tgl_pinjam'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'anggota_id.required' => 'Anggota peminjam wajib dipilih.',
            'anggota_id.exists' => 'Data anggota tidak ditemukan.',
            'buku_id.required' => 'Buku yang dipinjam wajib dipilih.',
            'buku_id.exists' => 'Data buku tidak ditemukan.',
            'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tgl_kembali.required' => 'Tanggal batas kembali wajib diisi.',
            'tgl_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
        ];
    }
}
