<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    public $incrementing = false;
    protected $keyType = 'string';

    public function kota() {
        return $this->belongsTo(kota::class, 'kota_id', 'id');
    }
    public function toko() {
        return $this->hasMany(toko::class, 'kecamatan_id', 'id');
    }
}
