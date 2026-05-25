<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'kota';
    public $incrementing = false;
    protected $keyType = 'string';

    public function provinsi() {
        return $this->belongsTo(provinsi::class, 'provinsi_id', 'id');
    }

    public function kecamatan() {
        return $this->hasMany(kecamatan::class, 'kota_id', 'id');
    }
    public function toko() {
        return $this->hasMany(toko::class, 'kota_id', 'id');
    }
}
