<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\StorePengembalianRequest;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    private const DENDA_PER_HARI = 2000;

    public function index(Request $request): View
    {
        $peminjaman = Peminjaman::query()
            ->with(['anggota', 'buku'])
            ->when($request->query('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->query('q'), function ($query, $keyword) {
                $query->whereHas('anggota', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                })->orWhereHas('buku', function ($q) use ($keyword) {
                    $q->where('judul', 'like', "%{$keyword}%");
                });
            })
            ->latest('tgl_pinjam')
            ->paginate(10)
            ->withQueryString();

        return view('peminjaman.index', [
            'peminjaman' => $peminjaman,
            'q' => $request->query('q'),
            'status' => $request->query('status'),
        ]);
    }

    public function create(): View
    {
        return view('peminjaman.create', [
            'anggotaList' => Anggota::orderBy('nama')->get(),
            'bukuList' => Buku::where('stok', '>', 0)->orderBy('judul')->get(),
        ]);
    }

    public function store(StorePeminjamanRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $buku = Buku::findOrFail($data['buku_id']);

        if ($buku->stok < 1) {
            return back()
                ->withInput()
                ->with('error', 'Stok buku "'.$buku->judul.'" sudah habis dan tidak dapat dipinjam.');
        }

        DB::transaction(function () use ($data, $buku) {
            Peminjaman::create([
                ...$data,
                'status' => Peminjaman::STATUS_DIPINJAM,
            ]);

            $buku->decrement('stok');
        });

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Transaksi peminjaman berhasil disimpan.');
    }

    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['anggota', 'buku', 'pengembalian']);

        $estimasiDenda = 0;
        if ($peminjaman->status === Peminjaman::STATUS_DIPINJAM && $peminjaman->terlambat) {
            $estimasiDenda = $peminjaman->jumlah_hari_terlambat * self::DENDA_PER_HARI;
        }

        return view('peminjaman.show', [
            'peminjaman' => $peminjaman,
            'estimasiDenda' => $estimasiDenda,
            'dendaPerHari' => self::DENDA_PER_HARI,
        ]);
    }

    public function kembalikan(StorePengembalianRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status === Peminjaman::STATUS_DIKEMBALIKAN) {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $data = $request->validated();

        $tglKembaliAktual = \Carbon\Carbon::parse($data['tgl_kembali_aktual'])->startOfDay();
        $batasKembali = $peminjaman->tgl_kembali->copy()->startOfDay();
        $hariTerlambat = $tglKembaliAktual->gt($batasKembali)
            ? $batasKembali->diffInDays($tglKembaliAktual)
            : 0;
        $denda = $hariTerlambat * self::DENDA_PER_HARI;

        DB::transaction(function () use ($peminjaman, $data, $denda) {
            $peminjaman->pengembalian()->create([
                'tgl_kembali_aktual' => $data['tgl_kembali_aktual'],
                'denda' => $denda,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            $peminjaman->update(['status' => Peminjaman::STATUS_DIKEMBALIKAN]);

            $peminjaman->buku()->increment('stok');
        });

        return redirect()
            ->route('peminjaman.show', $peminjaman)
            ->with('success', 'Buku berhasil dikembalikan.'.($denda > 0 ? ' Denda keterlambatan: Rp '.number_format($denda, 0, ',', '.').'.' : ''));
    }

    public function destroy(Peminjaman $peminjaman): RedirectResponse
    {
        if ($peminjaman->status === Peminjaman::STATUS_DIPINJAM) {
            $peminjaman->buku()->increment('stok');
        }

        $peminjaman->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Transaksi peminjaman berhasil dihapus.');
    }
}
