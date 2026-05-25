<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'tokos';

    protected $fillable = [
        'user_id',
        'nama_toko',
        'foto_toko',
        'deskripsi',
        'no_hp',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
    ];
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function provinsi() {
        return $this->belongsTo(provinsi::class);
    }
    public function kota() {
        return $this->belongsTo(kota::class);
    }
    public function kecamatan() {
        return $this->belongsTo(kecamatan::class);
    }
}
