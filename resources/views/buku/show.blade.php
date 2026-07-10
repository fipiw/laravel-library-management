@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    <div class="mb-4">
        <a href="{{ route('buku.index') }}" class="text-muted-custom" style="font-size: 14px;"><i class="bi bi-arrow-left"></i> Kembali ke Data Buku</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card-system text-center">
                <img src="{{ $buku->cover_url }}" alt="{{ $buku->judul }}" class="img-fluid mb-3" style="max-height: 280px; border-radius: var(--radius-md); border: 1px solid var(--color-hairline);">
                <h3 style="font-size: 18px; font-family: var(--font-sans); font-weight: 500;">{{ $buku->judul }}</h3>
                <p class="text-muted-custom" style="font-size: 14px;">{{ $buku->penulis }}</p>
                @if ($buku->stok_habis)
                    <span class="badge-system badge-error">Stok Habis</span>
                @else
                    <span class="badge-system badge-success">Stok: {{ $buku->stok }}</span>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-system h-100">
                <h3 class="mb-3" style="font-size: 16px; font-family: var(--font-sans); font-weight: 500;">Informasi Buku</h3>
                <dl class="mb-0">
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Kode Buku</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $buku->kode_buku }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Penerbit</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $buku->penerbit }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Tahun Terbit</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $buku->tahun }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Total Dipinjam</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $buku->peminjaman()->count() }}x</dd>
                    </div>
                </dl>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('buku.edit', $buku) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Edit</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-system text-center mb-3">
                <h3 class="mb-3" style="font-size: 16px; font-family: var(--font-sans); font-weight: 500;">QR Code Buku</h3>
                <div class="d-flex justify-content-center mb-2">{!! $qrCode !!}</div>
                <p class="text-muted-soft">Pindai untuk membuka detail buku ini.</p>
            </div>

            <div class="card-system text-center">
                <h3 class="mb-3" style="font-size: 16px; font-family: var(--font-sans); font-weight: 500;">Barcode Kode Buku</h3>
                
                <div id="barcode-area">
                    <p style="font-size: 11px; color: var(--color-muted); margin-bottom: 4px;">{{ $buku->kode_buku }}</p>
                    <img src="{{ route('buku.barcode', $buku) }}" alt="Barcode {{ $buku->kode_buku }}" class="img-fluid">
                    <p style="font-size: 11px; color: var(--color-muted); margin-top: 4px;">{{ $buku->judul }}</p>
                </div>

                <button onclick="printBarcode()" class="btn btn-secondary mt-3" style="width: 100%;">
                    <i class="bi bi-printer"></i> Print Barcode
                </button>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    function printBarcode() {
        const barcodeArea = document.getElementById('barcode-area').innerHTML;

        const printWindow = window.open('', '_blank', 'width=400,height=300');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>Print Barcode - {{ $buku->kode_buku }}</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; }

                    body {
                        font-family: sans-serif;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        background: white;
                    }

                    .label-wrapper {
                        text-align: center;
                        padding: 16px;
                        border: 1px dashed #ccc;
                        border-radius: 6px;
                        width: 200px;
                    }

                    p {
                        font-size: 11px;
                        color: #555;
                        margin: 3px 0;
                    }

                    img {
                        width: 160px;
                        height: auto;
                    }

                    @media print {
                        body {
                            display: block;
                        }

                        .label-wrapper {
                            border: none;
                            margin: 0 auto;
                        }

                        @page {
                            size: 58mm 30mm;
                            margin: 2mm;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="label-wrapper">
                    ${barcodeArea}
                </div>
            </body>
            </html>
        `);

        printWindow.document.close();

        // Tunggu gambar barcode selesai dimuat sebelum print
        printWindow.onload = function () {
            setTimeout(function () {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }, 500);
        };
    }
</script>
@endpush
@endsection


