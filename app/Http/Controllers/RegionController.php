<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;

class RegionController extends Controller
{
    public function provinsi()
    {
        return Provinsi::all();
    }

    public function kota($id)
    {
        return Kota::where('provinsi_id', $id)->get();
    }

    public function kecamatan($id)
    {
        return Kecamatan::where('kota_id', $id)->get();
    }
}
