@csrf
@if (isset($buku))
    @method('PUT')
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="kode_buku" class="form-label">Kode Buku</label>
        <input type="text" name="kode_buku" id="kode_buku" class="form-control @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku', $buku->kode_buku ?? '') }}" placeholder="BK-0001" required>
        @error('kode_buku') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="tahun" class="form-label">Tahun Terbit</label>
        <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $buku->tahun ?? '') }}" placeholder="2026" required>
        @error('tahun') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="judul" class="form-label">Judul Buku</label>
        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul ?? '') }}" placeholder="Judul buku" required>
        @error('judul') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="penulis" class="form-label">Penulis</label>
        <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $buku->penulis ?? '') }}" placeholder="Nama penulis" required>
        @error('penulis') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="penerbit" class="form-label">Penerbit</label>
        <input type="text" name="penerbit" id="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $buku->penerbit ?? '') }}" placeholder="Nama penerbit" required>
        @error('penerbit') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="stok" class="form-label">Stok</label>
        <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok ?? 0) }}" min="0" required>
        @error('stok') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="cover" class="form-label">Cover Buku</label>
        <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
        <div class="form-text">Format jpg/png/webp, maksimal 2MB. (Opsional)</div>
        @error('cover') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

        @if (isset($buku) && $buku->cover)
            <img src="{{ $buku->cover_url }}" alt="cover saat ini" class="cover-thumb mt-2">
        @endif
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
</div>


