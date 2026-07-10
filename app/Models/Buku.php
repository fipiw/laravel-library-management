<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'buku';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'stok',
        'cover',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'stok' => 'integer',
        ];
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function scopeCari($query, ?string $keyword)
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
                ->orWhere('penulis', 'like', "%{$keyword}%")
                ->orWhere('kode_buku', 'like', "%{$keyword}%")
                ->orWhere('penerbit', 'like', "%{$keyword}%");
        });
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover
            ? asset('storage/'.$this->cover)
            : asset('img/no-cover.svg');
    }

    public function getStokHabisAttribute(): bool
    {
        return $this->stok <= 0;
    }
}
