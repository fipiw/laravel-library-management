<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $dariTanggal = $request->query('dari_tanggal');
        $sampaiTanggal = $request->query('sampai_tanggal');

        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->when($dariTanggal, fn ($q) => $q->whereDate('tgl_pinjam', '>=', $dariTanggal))
            ->when($sampaiTanggal, fn ($q) => $q->whereDate('tgl_pinjam', '<=', $sampaiTanggal))
            ->latest('tgl_pinjam')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.index', [
            'peminjaman'     => $peminjaman,
            'dariTanggal'    => $dariTanggal,
            'sampaiTanggal'  => $sampaiTanggal,
            'totalBuku'      => Buku::count(),
            'totalAnggota'   => Anggota::count(),
            'totalTransaksi' => Peminjaman::count(),
            'totalDenda'     => Peminjaman::with('pengembalian')
                                    ->get()
                                    ->sum(fn ($p) => $p->pengembalian->denda ?? 0),
        ]);
    }

    public function exportPdf(Request $request): \Illuminate\Http\Response
    {
        $peminjaman = $this->dataLaporan($request);

        $pdf = Pdf::loadView('laporan.pdf', [
            'peminjaman'    => $peminjaman,
            'dariTanggal'   => $request->query('dari_tanggal'),
            'sampaiTanggal' => $request->query('sampai_tanggal'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        $peminjaman = $this->dataLaporan($request);
        $filename   = 'laporan-peminjaman-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($peminjaman) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['No', 'Anggota', 'Judul Buku', 'Tgl Pinjam', 'Batas Kembali', 'Status', 'Denda (Rp)']);

            foreach ($peminjaman as $i => $item) {
                fputcsv($handle, [
                    $i + 1,
                    $item->anggota->nama,
                    $item->buku->judul,
                    $item->tgl_pinjam->format('d-m-Y'),
                    $item->tgl_kembali->format('d-m-Y'),
                    $item->status,
                    number_format($item->pengembalian->denda ?? 0, 0, ',', '.'),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportBukuExcel(): StreamedResponse
    {
        $filename = 'data-buku-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['No', 'Kode Buku', 'Judul', 'Penulis', 'Penerbit', 'Tahun', 'Stok']);

            foreach (Buku::orderBy('judul')->get() as $i => $buku) {
                fputcsv($handle, [
                    $i + 1,
                    $buku->kode_buku,
                    $buku->judul,
                    $buku->penulis,
                    $buku->penerbit,
                    $buku->tahun,
                    $buku->stok,
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportAnggotaExcel(): StreamedResponse
    {
        $filename = 'data-anggota-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['No', 'Nama', 'Alamat', 'No HP', 'Email']);

            foreach (Anggota::orderBy('nama')->get() as $i => $anggota) {
                fputcsv($handle, [
                    $i + 1,
                    $anggota->nama,
                    $anggota->alamat,
                    $anggota->no_hp,
                    $anggota->email,
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function dataLaporan(Request $request)
    {
        return Peminjaman::with(['anggota', 'buku', 'pengembalian'])
            ->when($request->query('dari_tanggal'), fn ($q) => $q->whereDate('tgl_pinjam', '>=', $request->query('dari_tanggal')))
            ->when($request->query('sampai_tanggal'), fn ($q) => $q->whereDate('tgl_pinjam', '<=', $request->query('sampai_tanggal')))
            ->latest('tgl_pinjam')
            ->get();
    }
}