@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="mb-4">
        <h1 class="mb-1">Laporan</h1>
        <p class="text-muted-custom">Ringkasan dan ekspor data transaksi perpustakaan.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">{{ $totalBuku }}</div>
                <div class="stat-label">TOTAL JUDUL BUKU</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">{{ $totalAnggota }}</div>
                <div class="stat-label">TOTAL ANGGOTA</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">{{ $totalTransaksi }}</div>
                <div class="stat-label">TOTAL TRANSAKSI</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-value">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                <div class="stat-label">TOTAL DENDA TERKUMPUL</div>
            </div>
        </div>
    </div>

    <div class="card-system mb-3">
        <form action="{{ route('laporan.index') }}" method="GET" class="d-flex gap-2 flex-wrap align-items-end">
            <div>
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" value="{{ $dariTanggal }}" class="form-control">
            </div>
            <div>
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" value="{{ $sampaiTanggal }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-secondary"><i class="bi bi-funnel"></i> Terapkan</button>

            <div class="ms-auto d-flex gap-2 flex-wrap">
                <a href="{{ route('laporan.export-pdf', request()->query()) }}" class="btn btn-secondary"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
                <a href="{{ route('laporan.export-excel', request()->query()) }}" class="btn btn-secondary"><i class="bi bi-file-earmark-spreadsheet"></i> Export CSV</a>
            </div>
        </form>
    </div>

    <div class="d-flex gap-2 flex-wrap mb-3">
        <a href="{{ route('laporan.buku.export-excel') }}" class="btn btn-secondary btn-sm"><i class="bi bi-download"></i> Export Data Buku (Excel)</a>
        <a href="{{ route('laporan.anggota.export-excel') }}" class="btn btn-secondary btn-sm"><i class="bi bi-download"></i> Export Data Anggota (Excel)</a>
    </div>

    <div class="table-responsive">
        <table class="table-system">
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr>
                        <td>{{ $item->anggota->nama }}</td>
                        <td>{{ $item->buku->judul }}</td>
                        <td>{{ $item->tgl_pinjam->format('d M Y') }}</td>
                        <td>{{ $item->tgl_kembali->format('d M Y') }}</td>
                        <td>
                            @if ($item->status === 'Dipinjam')
                                <span class="badge-system {{ $item->terlambat ? 'badge-error' : 'badge-warning' }}">{{ $item->terlambat ? 'Terlambat' : 'Dipinjam' }}</span>
                            @else
                                <span class="badge-system badge-success">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if (($item->pengembalian->denda ?? 0) > 0)
                                Rp {{ number_format($item->pengembalian->denda, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted-custom">Tidak ada data pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $peminjaman->links() }}
    </div>
@endsection


