<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $jumlahBuku = Buku::sum('stok') + Peminjaman::where('status', Peminjaman::STATUS_DIPINJAM)->count();
        $jumlahJudulBuku = Buku::count();
        $jumlahAnggota = Anggota::count();
        $jumlahBukuDipinjam = Peminjaman::where('status', Peminjaman::STATUS_DIPINJAM)->count();
        $jumlahBukuTersedia = (int) Buku::sum('stok');

        $grafikPeminjaman = collect(range(0, 5))
            ->map(function (int $i) {
                $tanggal = now()->subMonths(5 - $i);

                return [
                    'bulan' => $tanggal->translatedFormat('M Y'),
                    'total' => Peminjaman::whereYear('tgl_pinjam', $tanggal->year)
                        ->whereMonth('tgl_pinjam', $tanggal->month)
                        ->count(),
                ];
            });

        $bukuStokHabis = Buku::where('stok', '<=', 0)->orderBy('judul')->get();

        $peminjamanTerlambat = Peminjaman::with(['anggota', 'buku'])
            ->where('status', Peminjaman::STATUS_DIPINJAM)
            ->whereDate('tgl_kembali', '<', now()->startOfDay())
            ->orderBy('tgl_kembali')
            ->get();

        return view('dashboard.index', [
            'jumlahJudulBuku' => $jumlahJudulBuku,
            'jumlahAnggota' => $jumlahAnggota,
            'jumlahBukuDipinjam' => $jumlahBukuDipinjam,
            'jumlahBukuTersedia' => $jumlahBukuTersedia,
            'grafikPeminjaman' => $grafikPeminjaman,
            'bukuStokHabis' => $bukuStokHabis,
            'peminjamanTerlambat' => $peminjamanTerlambat,
        ]);
    }
}
