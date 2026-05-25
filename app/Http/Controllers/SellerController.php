<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    private function getToko()
    {
        return Toko::where('user_id', Auth::id())->first();
    }

    public function dashboard()
    {
        return view('seller.dashboard');
    }

    public function laporan()
    {
        return view('seller.laporan');
    }

    public function toko()
    {   
        $dataToko = $this->getToko();
        return view('seller.toko', compact(
            'dataToko',
        ));
    }

    public function orderan()
    {   
        $dataToko = $this->getToko();
        return view('seller.orderan-saya');
    }
}