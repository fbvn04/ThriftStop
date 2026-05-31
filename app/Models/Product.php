<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'toko_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'kondisi',
        'ukuran',
        'foto_utama',
        'foto_lainnya',
        'is_aktif',
    ];

    protected $casts = [
        'foto_lainnya' => 'array',
        'is_aktif'     => 'boolean',
        'harga'        => 'integer',
        'stok'         => 'integer',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function getLabelStokAttribute(): string
    {
        if ($this->stok === 0) {
            return 'Habis';
        }

        if ($this->stok <= 2) {
            return 'Hampir Habis';
        }

        return 'Tersedia';
    }

    public function getWarnaBadgeAttribute(): string
    {
        if ($this->stok === 0) {
            return 'habis';
        }

        if ($this->stok <= 2) {
            return 'sedikit';
        }

        return '';
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}