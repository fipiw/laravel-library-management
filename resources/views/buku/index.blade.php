@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="mb-1">Data Buku</h1>
            <p class="text-muted-custom">Kelola koleksi buku perpustakaan sekolah.</p>
        </div>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Buku
        </a>
    </div>

    <div class="card-system mb-3">
        <form action="{{ route('buku.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
            <div class="flex-grow-1" style="min-width: 220px;">
                <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari judul, penulis, kode, atau penerbit...">
            </div>
            <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i> Cari</button>
            @if ($q)
                <a href="{{ route('buku.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table-system">
            <thead>
                <tr>
                    <th>Cover</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $item)
                    <tr>
                        <td><img src="{{ $item->cover_url }}" alt="{{ $item->judul }}" class="cover-thumb"></td>
                        <td>{{ $item->kode_buku }}</td>
                        <td>
                            <a href="{{ route('buku.show', $item) }}" class="text-link" style="color: var(--color-ink); font-weight: 500;">{{ $item->judul }}</a>
                        </td>
                        <td>{{ $item->penulis }}</td>
                        <td>{{ $item->penerbit }}</td>
                        <td>{{ $item->tahun }}</td>
                        <td>
                            @if ($item->stok_habis)
                                <span class="badge-system badge-error">Habis</span>
                            @else
                                <span class="badge-system badge-success">{{ $item->stok }}</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('buku.show', $item) }}" class="btn-icon-circular" title="Detail / QR Code"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('buku.edit', $item) }}" class="btn-icon-circular" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('buku.destroy', $item) }}" method="POST" data-confirm-delete="Hapus buku '{{ $item->judul }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-circular" title="Hapus" style="color: var(--color-error);"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted-custom">Belum ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $buku->links() }}
    </div>
@endsection


