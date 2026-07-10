<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnggotaRequest;
use App\Models\Anggota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    public function index(Request $request): View
    {
        $anggota = Anggota::query()
            ->cari($request->query('q'))
            ->withCount('peminjaman')
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('anggota.index', [
            'anggota' => $anggota,
            'q' => $request->query('q'),
        ]);
    }

    public function create(): View
    {
        return view('anggota.create');
    }


    public function store(StoreAnggotaRequest $request): RedirectResponse
    {
        Anggota::create($request->validated());

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }


    public function show(Anggota $anggota): View
    {
        $anggota->load(['peminjaman' => function ($query) {
            $query->with('buku')->latest('tgl_pinjam');
        }]);

        return view('anggota.show', ['anggota' => $anggota]);
    }

    public function edit(Anggota $anggota): View
    {
        return view('anggota.edit', ['anggota' => $anggota]);
    }

    public function update(StoreAnggotaRequest $request, Anggota $anggota): RedirectResponse
    {
        $anggota->update($request->validated());

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota): RedirectResponse
    {
        if ($anggota->peminjaman()->exists()) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }    

    public function cetakKartu(Anggota $anggota): \Illuminate\Http\Response
    {
        $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)
            ->format('svg')
            ->errorCorrection('M')
            ->generate('Anggota: '.$anggota->nama.' | Email: '.$anggota->email);
        $qrCode = 'data:image/svg+xml;base64,'.base64_encode($qrCode);

        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        $barcodeSvg = $generator->getBarcode(
            str_pad($anggota->id, 10, '0', STR_PAD_LEFT),
            $generator::TYPE_CODE_128,
            1.5,
            30
        );
        $barcode = 'data:image/svg+xml;base64,'.base64_encode($barcodeSvg);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('anggota.kartu', [
            'anggota' => $anggota,
            'qrCode'  => $qrCode,
            'barcode' => $barcode,
        ])->setPaper([0, 0, 241.89, 153.07]);

        return $pdf->stream('kartu-anggota-'.$anggota->nama.'.pdf');
    }
}