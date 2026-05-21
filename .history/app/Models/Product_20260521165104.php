<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Produk extends Model
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

    // ── Relasi ke Toko
    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    // ── Helper: label badge stok
    public function getLabelStokAttribute(): string
    {
        if ($this->stok === 0) return 'Habis';
        if ($this->stok <= 2) return 'Hampir Habis';
        return 'Tersedia';
    }

    // ── Helper: warna badge stok (untuk class CSS)
    public function getWarnaBadgeAttribute(): string
    {
        if ($this->stok === 0) return 'habis';
        if ($this->stok <= 2) return 'sedikit';
        return '';
    }

    // ── Scope: hanya produk aktif
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    // ── Scope: filter kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}