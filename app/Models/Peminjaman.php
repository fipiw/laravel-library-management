<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'peminjaman';

    public const STATUS_DIPINJAM = 'Dipinjam';

    public const STATUS_DIKEMBALIKAN = 'Dikembalikan';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tgl_pinjam' => 'date',
            'tgl_kembali' => 'date',
        ];
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    public function getTerlambatAttribute(): bool
    {
        return $this->status === self::STATUS_DIPINJAM
            && now()->startOfDay()->gt($this->tgl_kembali);
    }

    public function getJumlahHariTerlambatAttribute(): int
    {
        if (! $this->terlambat) {
            return 0;
        }

        return (int) now()->startOfDay()->diffInDays($this->tgl_kembali);
    }
}
