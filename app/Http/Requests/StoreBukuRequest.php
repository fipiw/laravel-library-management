<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBukuRequest extends FormRequest
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
        $bukuId = $this->route('buku')?->id;

        return [
            'kode_buku' => ['required', 'string', 'max:50', Rule::unique('buku', 'kode_buku')->ignore($bukuId)],
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'stok' => ['required', 'integer', 'min:0'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'kode_buku.unique' => 'Kode buku sudah digunakan, gunakan kode lain.',
            'judul.required' => 'Judul buku wajib diisi.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun.required' => 'Tahun terbit wajib diisi.',
            'tahun.integer' => 'Tahun terbit harus berupa angka.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.min' => 'Stok buku tidak boleh kurang dari 0.',
            'cover.image' => 'File cover harus berupa gambar.',
            'cover.mimes' => 'Format cover hanya boleh jpg, jpeg, png, atau webp.',
            'cover.max' => 'Ukuran cover maksimal 2MB.',
        ];
    }
}
