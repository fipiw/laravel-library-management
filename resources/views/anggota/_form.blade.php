@csrf
@if (isset($anggota))
    @method('PUT')
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $anggota->nama ?? '') }}" placeholder="Nama anggota" required>
        @error('nama') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $anggota->email ?? '') }}" placeholder="nama@email.com" required>
        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="no_hp" class="form-label">Nomor HP</label>
        <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $anggota->no_hp ?? '') }}" placeholder="08xxxxxxxxxx" required>
        @error('no_hp') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="tgl_daftar" class="form-label">Tanggal Daftar</label>
        <input type="date" name="tgl_daftar" id="tgl_daftar" class="form-control @error('tgl_daftar') is-invalid @enderror" value="{{ old('tgl_daftar', isset($anggota) ? $anggota->tgl_daftar?->format('Y-m-d') : now()->format('Y-m-d')) }}">
        @error('tgl_daftar') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat lengkap" required>{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
        @error('alamat') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Batal</a>
</div>


