@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div class="mb-4">
        <a href="{{ route('peminjaman.index') }}" class="text-muted-custom" style="font-size: 14px;"><i class="bi bi-arrow-left"></i> Kembali ke Transaksi Peminjaman</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card-system h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3 style="font-size: 18px; font-family: var(--font-sans); font-weight: 500;">Informasi Transaksi</h3>
                    @if ($peminjaman->status === 'Dipinjam')
                        <span class="badge-system {{ $peminjaman->terlambat ? 'badge-error' : 'badge-warning' }}">{{ $peminjaman->terlambat ? 'Terlambat' : 'Dipinjam' }}</span>
                    @else
                        <span class="badge-system badge-success">Dikembalikan</span>
                    @endif
                </div>

                <dl class="mb-0">
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Anggota</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $peminjaman->anggota->nama }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Buku</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $peminjaman->buku->judul }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Tanggal Pinjam</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $peminjaman->tgl_pinjam->format('d M Y') }}</dd>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="font-size: 14px;">
                        <dt class="text-muted-custom fw-normal">Batas Kembali</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $peminjaman->tgl_kembali->format('d M Y') }}</dd>
                    </div>
                </dl>

                @if ($peminjaman->status === 'Dipinjam' && $peminjaman->terlambat)
                    <div class="alert-system alert-error-system mt-3 mb-0">
                        <i class="bi bi-clock"></i>
                        Terlambat {{ $peminjaman->jumlah_hari_terlambat }} hari. Estimasi denda: <strong>Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            @if ($peminjaman->status === 'Dipinjam')
                <div class="card-system h-100">
                    <h3 class="mb-3" style="font-size: 18px; font-family: var(--font-sans); font-weight: 500;">Proses Pengembalian</h3>
                    <p class="text-muted-custom mb-3" style="font-size: 14px;">Denda keterlambatan dihitung otomatis sebesar Rp {{ number_format($dendaPerHari, 0, ',', '.') }} per hari.</p>

                    <form action="{{ route('peminjaman.kembalikan', $peminjaman) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tgl_kembali_aktual" class="form-label">Tanggal Pengembalian</label>
                            <input type="date" name="tgl_kembali_aktual" id="tgl_kembali_aktual" class="form-control @error('tgl_kembali_aktual') is-invalid @enderror" value="{{ old('tgl_kembali_aktual', now()->format('Y-m-d')) }}" required>
                            @error('tgl_kembali_aktual') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Catatan kondisi buku, dll.">{{ old('keterangan') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Konfirmasi Pengembalian</button>
                    </form>
                </div>
            @else
                <div class="card-system h-100">
                    <h3 class="mb-3" style="font-size: 18px; font-family: var(--font-sans); font-weight: 500;">Data Pengembalian</h3>
                    <dl class="mb-0">
                        <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                            <dt class="text-muted-custom fw-normal">Tanggal Kembali</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $peminjaman->pengembalian->tgl_kembali_aktual->format('d M Y') }}</dd>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: var(--color-hairline-soft) !important; font-size: 14px;">
                            <dt class="text-muted-custom fw-normal">Denda</dt>
                            <dd class="mb-0" style="color: var(--color-ink);">
                                @if ($peminjaman->pengembalian->denda > 0)
                                    <span class="badge-system badge-error">Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="badge-system badge-success">Tidak ada denda</span>
                                @endif
                            </dd>
                        </div>
                        <div class="py-2" style="font-size: 14px;">
                            <dt class="text-muted-custom fw-normal mb-1">Keterangan</dt><dd class="mb-0" style="color: var(--color-ink);">{{ $peminjaman->pengembalian->keterangan ?: '-' }}</dd>
                        </div>
                    </dl>
                </div>
            @endif
        </div>
    </div>
@endsection


