<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
    public $incrementing = false;
    protected $keyType = 'string';

    public function kota() {
        return $this->hasMany(kota::class, 'provinsi_id', 'id');
    }
    public function toko() {
        return $this->hasMany(toko::class, 'provinsi_id', 'id');
    }

}
