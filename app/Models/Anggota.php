<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Anggota extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'anggota';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'email',
        'tgl_daftar',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tgl_daftar' => 'date',
        ];
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    public function scopeCari($query, ?string $keyword)
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(function ($q) use ($keyword) {
            $q->where('nama', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('no_hp', 'like', "%{$keyword}%");
        });
    }

    use SoftDeletes;
}