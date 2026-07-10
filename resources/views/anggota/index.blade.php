@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h1 class="mb-1">Data Anggota</h1>
            <p class="text-muted-custom">Kelola data anggota perpustakaan.</p>
        </div>
        <a href="{{ route('anggota.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Anggota
        </a>
    </div>

    <div class="card-system mb-3">
        <form action="{{ route('anggota.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
            <div class="flex-grow-1" style="min-width: 220px;">
                <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari nama, email, atau no HP...">
            </div>
            <button type="submit" class="btn btn-secondary"><i class="bi bi-search"></i> Cari</button>
            @if ($q)
                <a href="{{ route('anggota.index') }}" class="btn btn-secondary"><i class="bi bi-x-lg"></i> Reset</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table-system">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Email</th>
                    <th>Total Pinjam</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($anggota as $item)
                    <tr>
                        <td>
                            <a href="{{ route('anggota.show', $item) }}" class="text-link" style="color: var(--color-ink); font-weight: 500;">{{ $item->nama }}</a>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($item->alamat, 40) }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->email }}</td>
                        <td><span class="badge-system badge-pill">{{ $item->peminjaman_count }}x</span></td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('anggota.show', $item) }}" class="btn-icon-circular" title="Detail"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('anggota.edit', $item) }}" class="btn-icon-circular" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('anggota.destroy', $item) }}" method="POST" data-confirm-delete="Hapus anggota '{{ $item->nama }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-circular" title="Hapus" style="color: var(--color-error);"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted-custom">Belum ada data anggota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $anggota->links() }}
    </div>
@endsection


