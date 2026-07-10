@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h1 class="mb-1">Dashboard</h1>
        <p class="text-muted-custom">Ringkasan kondisi perpustakaan hari ini, {{ now()->translatedFormat('d F Y') }}.</p>
    </div>

    @if ($bukuStokHabis->isNotEmpty())
        <div class="alert-system alert-error-system mb-4">
            <i class="bi bi-exclamation-triangle"></i>
            <div>
                <strong>{{ $bukuStokHabis->count() }} judul buku stoknya habis:</strong>
                {{ $bukuStokHabis->pluck('judul')->take(4)->join(', ') }}@if($bukuStokHabis->count() > 4), dll.@endif
            </div>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-book"></i></div>
                <div class="stat-value">{{ $jumlahJudulBuku }}</div>
                <div class="stat-label">JUMLAH JUDUL BUKU</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--color-accent-teal);"><i class="bi bi-people"></i></div>
                <div class="stat-value">{{ $jumlahAnggota }}</div>
                <div class="stat-label">JUMLAH ANGGOTA</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--color-accent-amber);"><i class="bi bi-arrow-left-right"></i></div>
                <div class="stat-value">{{ $jumlahBukuDipinjam }}</div>
                <div class="stat-label">BUKU DIPINJAM</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: var(--color-success);"><i class="bi bi-check-lg"></i></div>
                <div class="stat-value">{{ $jumlahBukuTersedia }}</div>
                <div class="stat-label">BUKU TERSEDIA</div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card-system h-100">
                <h3 class="mb-3" style="font-size: 18px; font-family: var(--font-sans); font-weight: 500;">Grafik Peminjaman 6 Bulan Terakhir</h3>
                <canvas id="chartPeminjaman" height="100"></canvas>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card-system h-100">
                <h3 class="mb-3" style="font-size: 18px; font-family: var(--font-sans); font-weight: 500;">Peminjaman Terlambat</h3>
                @forelse ($peminjamanTerlambat->take(6) as $item)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--color-hairline-soft) !important;">
                        <div>
                            <div style="font-size: 14px; font-weight: 500; color: var(--color-ink);">{{ $item->buku->judul }}</div>
                            <div class="text-muted-soft">{{ $item->anggota->nama }} — batas {{ $item->tgl_kembali->format('d M Y') }}</div>
                        </div>
                        <a href="{{ route('peminjaman.show', $item) }}" class="badge-system badge-error">Detail</a>
                    </div>
                @empty
                    <p class="text-muted-custom" style="font-size: 14px;">Tidak ada peminjaman yang terlambat. Semua aman.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($grafikPeminjaman->pluck('bulan'));
        const data = @json($grafikPeminjaman->pluck('total'));

        const ctx = document.getElementById('chartPeminjaman');

        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: data,
                    backgroundColor: 'rgba(204, 120, 92, 0.7)',
                    borderColor: '#cc785c',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: '#ebe6df' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush


