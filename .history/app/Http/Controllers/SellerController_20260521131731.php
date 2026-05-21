<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $toko = $user->toko; // pastikan relasi hasOne Toko ada di model User

        return view('seller.dashboard', [
            'toko'              => $toko,
            'pemasukanBulanIni' => 10000000,
            'produkTerjual'     => 23,
            'totalProduk'       => 0,
            'pesananMasuk'      => 5,
            'ratingToko'        => 4.8,
            'pengunjung'        => 312,
            'growthPemasukan'   => 12,
            'growthProduk'      => -3,
            'pesananTerbaru'    => [],
            'produkTerlaris'    => [],
            'notifikasi'        => collect([]),
            'notifCount'        => 0,
            'pesananBaru'       => 0,
            'chartTahunan'      => [
                'labels' => ['2020','2021','2022','2023','2024','2025','2026','2027'],
                'data'   => [32, 29, 17, 14, 11, 9, 6, 2],
            ],
            'chartBulanan'      => [
                'labels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                'data'   => [5, 8, 6, 12, 9, 14, 11, 7, 10, 13, 8, 15],
            ],
        ]);
    }

    public function produk()
    {
        return view('seller.produk');
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