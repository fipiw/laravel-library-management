<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; color: #141413; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 2px; }
        p.sub { color: #6c6a64; margin-top: 0; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e6dfd8; padding: 6px 8px; text-align: left; }
        th { background-color: #efe9de; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; }
        .badge-success { background-color: #dff3e3; color: #2f6b3d; }
        .badge-warning { background-color: #fbeecb; color: #8a6710; }
        .badge-error { background-color: #f7dede; color: #c64545; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <h1>Laporan Transaksi Peminjaman</h1>
    <p class="sub">
        Sistem Informasi Perpustakaan
        @if ($dariTanggal || $sampaiTanggal)
            — Periode: {{ $dariTanggal ?: '...' }} s/d {{ $sampaiTanggal ?: '...' }}
        @endif
        — Dicetak: {{ now()->format('d M Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th>Status</th>
                <th class="text-end">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->anggota->nama }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td>{{ $item->tgl_pinjam->format('d-m-Y') }}</td>
                    <td>{{ $item->tgl_kembali->format('d-m-Y') }}</td>
                    <td>
                        @if ($item->status === 'Dipinjam')
                            <span class="badge {{ $item->terlambat ? 'badge-error' : 'badge-warning' }}">{{ $item->terlambat ? 'Terlambat' : 'Dipinjam' }}</span>
                        @else
                            <span class="badge badge-success">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="text-end">Rp {{ number_format($item->pengembalian->denda ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center; padding: 16px;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>


