<aside class="app-sidebar">
    <div class="brand">
        <svg class="spike" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L13.5 10.5L22 12L13.5 13.5L12 22L10.5 13.5L2 12L10.5 10.5L12 2Z" fill="#cc785c"/>
        </svg>
        <span>Sisfo Perpus</span>
    </div>

    <nav>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('buku.index') }}" class="nav-item {{ request()->routeIs('buku.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Data Buku
            @php $stokHabis = \App\Models\Buku::where('stok', '<=', 0)->count(); @endphp
            @if ($stokHabis > 0)
                <span style="
                    background-color: var(--color-error);
                    color: white;
                    font-size: 11px;
                    font-weight: 600;
                    padding: 2px 7px;
                    border-radius: 9999px;
                    margin-left: auto;
                    line-height: 1.4;
                ">{{ $stokHabis }}</span>
            @endif
        </a>
        <a href="{{ route('anggota.index') }}" class="nav-item {{ request()->routeIs('anggota.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Data Anggota
        </a>
        <a href="{{ route('peminjaman.index') }}" class="nav-item {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Peminjaman
        </a>
        <a href="{{ route('laporan.index') }}" class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i> Laporan
        </a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item" style="width: 100%; background: none; border: none; text-align: left; cursor: pointer;">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</aside>
