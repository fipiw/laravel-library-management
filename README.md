# Sistem Informasi Perpustakaan (UAS Pemrograman Web)

Aplikasi berbasis **Laravel 11** untuk mengelola perpustakaan sekolah dengan single admin user. Tampilan dibangun mengikuti **DESIGN.md** (warm-canvas editorial design system) menggunakan Bootstrap 5 sebagai layout dasar yang seluruh visualnya di-override lewat `public/css/app.css`.

## Fitur

**Wajib (sesuai soal UAS):**
- Dashboard (jumlah buku, anggota, buku dipinjam, buku tersedia)
- CRUD Data Buku, CRUD Data Anggota
- Transaksi Peminjaman & Pengembalian buku
- Laporan transaksi

**Nilai plus yang ditambahkan:**
- Level 1: Upload cover buku, pagination, search (buku & anggota)
- Level 2: Export PDF (DomPDF), Export Excel (Maatwebsite Excel), Grafik dashboard (Chart.js)
- Level 3: QR Code buku, Barcode buku (Code128 SVG)
- Tambahan: Notifikasi stok habis, perhitungan denda keterlambatan otomatis

## Kebutuhan Sistem
- PHP >= 8.2 dengan ekstensi: pdo_mysql, mbstring, gd, fileinfo, zip
- Composer 2.x
- MySQL 8 / MariaDB
- Node tidak wajib (tidak ada build asset, seluruh CSS/JS plain + CDN)

## Instalasi

```bash
# 1. Install dependency PHP
composer install

# 2. Salin file environment lalu sesuaikan kredensial database
cp .env.example .env
php artisan key:generate

# Edit .env:
# DB_DATABASE=perpustakaan
# DB_USERNAME=root
# DB_PASSWORD=

# 3. Buat database "perpustakaan" di MySQL, lalu jalankan migration + seeder
php artisan migrate --seed

# 4. Buat symlink storage agar cover buku bisa diakses publik
php artisan storage:link

# 5. Jalankan server
php artisan serve
```

Buka `http://127.0.0.1:8000` lalu login dengan akun admin hasil seeder:

```
Email    : admin@perpus.test
Password : password
```

## Struktur Folder Utama

```
app/
├── Exports/                 (class export Excel: Buku, Anggota, Peminjaman)
├── Http/
│   ├── Controllers/         (AuthController, DashboardController, BukuController,
│   │                          AnggotaController, PeminjamanController, LaporanController)
│   └── Requests/             (Form Request validasi)
├── Models/                   (User, Buku, Anggota, Peminjaman, Pengembalian)
└── Providers/

database/
├── migrations/
└── seeders/

resources/views/
├── layouts/app.blade.php
├── partials/ (sidebar, topbar)
├── auth/login.blade.php
├── dashboard/index.blade.php
├── buku/ (index, create, edit, show, _form)
├── anggota/ (index, create, edit, show, _form)
├── peminjaman/ (index, create, show)
└── laporan/ (index, pdf)

public/
├── css/app.css   (implementasi penuh token DESIGN.md)
├── js/app.js
└── img/no-cover.svg

routes/web.php
```

## Logika Bisnis Penting

- **Stok buku** otomatis berkurang saat transaksi peminjaman dibuat dan bertambah kembali saat buku dikembalikan atau transaksi peminjaman dihapus.
- **Denda keterlambatan** dihitung otomatis sebesar Rp 2.000/hari dari selisih tanggal pengembalian aktual terhadap batas tanggal kembali (lihat `PeminjamanController::kembalikan()`).
- **Buku/Anggota** yang masih memiliki riwayat peminjaman tidak dapat dihapus untuk menjaga integritas data.

## Catatan Desain

Seluruh token warna, tipografi, spacing, border-radius, dan komponen (button, card, input, table, badge, navbar) mengikuti `DESIGN.md` secara konsisten. Karena font asli (Copernicus, StyreneB) berlisensi privat, digunakan substitusi resmi yang disebutkan di `DESIGN.md`: **Cormorant Garamond** untuk display heading dan **Inter** untuk body/UI.
