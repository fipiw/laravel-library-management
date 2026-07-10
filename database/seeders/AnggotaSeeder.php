<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    /**
     * Seed beberapa data contoh anggota.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Budi Santoso', 'alamat' => 'Jl. Malioboro No. 1, Yogyakarta', 'no_hp' => '081234567890', 'email' => 'budi@sekolah.test', 'tgl_daftar' => now()->subMonths(3)],
            ['nama' => 'Siti Aminah', 'alamat' => 'Jl. Kaliurang No. 5, Yogyakarta', 'no_hp' => '081298765432', 'email' => 'siti@sekolah.test', 'tgl_daftar' => now()->subMonths(1)],
        ];

        foreach ($data as $item) {
            Anggota::firstOrCreate(['email' => $item['email']], $item);
        }
    }
}
