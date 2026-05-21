<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard()
    {
        return view('seller.dashboard');
    }

    public function produk()
    {
        return view('seller.kelola-produk');
    }

    public function laporan()
    {
        return view('seller.laporan');
    }

    public function toko()
    {
        return view('seller.toko');
    }

    public function orderan()
    {
        return view('seller.orderan');
    }
}