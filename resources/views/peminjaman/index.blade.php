@extends('layouts.app')

@section('title', 'Transaksi Peminjaman')

@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="mb-1">Transaksi Peminjaman</h1>
            <p class="text-muted-custom">Kelola transaksi peminjaman dan pengembalian buku.</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Peminjaman Baru
        </a>
    </div>

    <div class="card-system mb-3">
        <form action="{{ route('peminjaman.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
            <div class="flex-grow-1" style="min-width: 220px;">
                <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari nama anggota atau judul buku...">
            </div>
            <select name="status" class="form-select" style="max-width: 200px;">
                <option value="">Semua Status</option>
                <option value="Dipinjam" {{ $status === 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="Dikembalikan" {{ $status === 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
            <button type="submit" class="btn btn-secondary"><i class="bi bi-funnel"></i> Filter</button>
            @if ($q || $status)
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Reset</a>
            @endif
        </form>
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
                    <th class="text-end">Aksi</th>
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
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('peminjaman.show', $item) }}" class="btn-icon-circular" title="Detail"><i class="bi bi-eye"></i></a>
                                @if ($item->status === 'Dipinjam')
                                    <form action="{{ route('peminjaman.destroy', $item) }}" method="POST" data-confirm-delete="Hapus transaksi ini?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-circular" title="Hapus" style="color: var(--color-error);"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted-custom">Belum ada transaksi peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $peminjaman->links() }}
    </div>
@endsection


