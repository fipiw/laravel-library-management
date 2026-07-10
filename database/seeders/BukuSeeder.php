<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Seed beberapa data contoh buku.
     */
    public function run(): void
    {
        $data = [
            ['kode_buku' => 'BK-0001', 'judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun' => 2005, 'stok' => 5],
            ['kode_buku' => 'BK-0002', 'judul' => 'Bumi Manusia', 'penulis' => 'Pramoedya Ananta Toer', 'penerbit' => 'Hasta Mitra', 'tahun' => 1980, 'stok' => 3],
            ['kode_buku' => 'BK-0003', 'judul' => 'Negeri 5 Menara', 'penulis' => 'Ahmad Fuadi', 'penerbit' => 'Gramedia', 'tahun' => 2009, 'stok' => 0],
            ['kode_buku' => 'BK-0004', 'judul' => 'Pemrograman Web dengan Laravel', 'penulis' => 'Tim Penulis', 'penerbit' => 'Informatika', 'tahun' => 2023, 'stok' => 8],
        ];

        foreach ($data as $item) {
            Buku::firstOrCreate(['kode_buku' => $item['kode_buku']], $item);
        }
    }
}
