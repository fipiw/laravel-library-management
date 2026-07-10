<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BukuController extends Controller
{
    public function index(Request $request): View
    {
        $buku = Buku::query()
            ->cari($request->query('q'))
            ->orderBy('judul')
            ->paginate(10)
            ->withQueryString();

        return view('buku.index', [
            'buku' => $buku,
            'q' => $request->query('q'),
        ]);
    }

    public function create(): View
    {
        return view('buku.create');
    }

    public function store(StoreBukuRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('cover-buku', 'public');
        }

        Buku::create($data);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function show(Buku $buku): View
    {
        $qrCode = QrCode::size(180)->generate(route('buku.show', $buku));

        return view('buku.show', [
            'buku' => $buku,
            'qrCode' => $qrCode,
        ]);
    }

    public function edit(Buku $buku): View
    {
        return view('buku.edit', ['buku' => $buku]);
    }

    public function update(StoreBukuRequest $request, Buku $buku): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }

            $data['cover'] = $request->file('cover')->store('cover-buku', 'public');
        }

        $buku->update($data);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        if ($buku->peminjaman()->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus.');
    }

    public function barcode(Buku $buku)
    {
        $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
        $barcode = $generator->getBarcode($buku->kode_buku, $generator::TYPE_CODE_128, 2, 60);

        return response($barcode, 200, [
            'Content-Type' => 'image/svg+xml',
        ]);
    }
}
