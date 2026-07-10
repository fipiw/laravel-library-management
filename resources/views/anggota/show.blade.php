@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <div class="mb-4">
        <a href="{{ route('anggota.index') }}" class="text-muted-custom" style="font-size: 14px;"><i class="bi bi-arrow-left"></i> Kembali ke Data Anggota</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card-system">
                <h3 class="mb-3" style="font-size: 18px; font-family: var(--font-sans); font-weight: 500;">{{ $anggota->nama }}</h3>
                <dl class="mb-0">
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Email</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $anggota->email }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">No HP</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $anggota->no_hp }}</dd>
                    </div>
                    <div class="py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal mb-1">Alamat</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $anggota->alamat }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Tanggal Daftar</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $anggota->tgl_daftar?->format('d M Y') ?? '-' }}</dd>
                    </div>
                </dl>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('anggota.edit', $anggota) }}" class="btn btn-secondary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('anggota.kartu', $anggota) }}" target="_blank" class="btn btn-primary">
                        <i class="bi bi-credit-card"></i> Cetak Kartu
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card-system">
                <h3 class="mb-3" style="font-size: 16px; font-family: var(--font-sans); font-weight: 500;">Riwayat Peminjaman</h3>
                <div class="table-responsive">
                    <table class="table-system">
                        <thead>
                            <tr><th>Buku</th><th>Tgl Pinjam</th><th>Batas Kembali</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse ($anggota->peminjaman as $p)
                                <tr>
                                    <td><a href="{{ route('peminjaman.show', $p) }}" style="color: var(--color-ink); font-weight: 500;">{{ $p->buku->judul }}</a></td>
                                    <td>{{ $p->tgl_pinjam->format('d M Y') }}</td>
                                    <td>{{ $p->tgl_kembali->format('d M Y') }}</td>
                                    <td>
                                        @if ($p->status === 'Dipinjam')
                                            <span class="badge-system {{ $p->terlambat ? 'badge-error' : 'badge-warning' }}">{{ $p->terlambat ? 'Terlambat' : 'Dipinjam' }}</span>
                                        @else
                                            <span class="badge-system badge-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted-custom">Belum ada riwayat peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


