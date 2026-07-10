@extends('layouts.app')

@section('title', 'Peminjaman Baru')

@section('content')
    <div class="mb-4">
        <h1 class="mb-1">Peminjaman Baru</h1>
        <p class="text-muted-custom">Catat transaksi peminjaman buku oleh anggota.</p>
    </div>

    <div class="card-system" style="max-width: 720px;">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="anggota_id" class="form-label">Anggota</label>
                    <select name="anggota_id" id="anggota_id" class="form-select @error('anggota_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach ($anggotaList as $a)
                            <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>{{ $a->nama }}</option>
                        @endforeach
                    </select>
                    @error('anggota_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="buku_id" class="form-label">Buku</label>
                    <select name="buku_id" id="buku_id" class="form-select @error('buku_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Buku --</option>
                        @forelse ($bukuList as $b)
                            <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>{{ $b->judul }} (stok: {{ $b->stok }})</option>
                        @empty
                            <option value="" disabled>Tidak ada buku dengan stok tersedia</option>
                        @endforelse
                    </select>
                    @error('buku_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control @error('tgl_pinjam') is-invalid @enderror" value="{{ old('tgl_pinjam', now()->format('Y-m-d')) }}" required>
                    @error('tgl_pinjam') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label for="tgl_kembali" class="form-label">Batas Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control @error('tgl_kembali') is-invalid @enderror" value="{{ old('tgl_kembali', now()->addDays(7)->format('Y-m-d')) }}" required>
                    @error('tgl_kembali') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan Peminjaman</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection


