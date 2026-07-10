# Library Management System

A web-based Library Management System built using Laravel.

## Features

- Dashboard
- Book Management
- Member Management
- Loan Management
- Return Management
- Reports
- Authentication

## Tech Stack

- Laravel
- PHP
- MySQL
- Bootstrap
- JavaScript

## Installation

1. Clone repository
2. Install Composer dependencies
3. Configure `.env`
4. Run migrations
5. Start the development server

## Screenshots

(Add screenshots here)

## Author

Your Name
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
