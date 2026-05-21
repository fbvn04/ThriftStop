<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function getToko()
    {
        dd(Auth::id());
        return Toko::where('user_id', Auth::id())->firstOrFail();
    }

    public function index(Request $request)
    {
        try {
            $toko = $this->getToko();
            dd($toko);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $toko = $this->getToko();
    }

    public function show(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);
    }

    public function update(Request $request, Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);
    }

    public function destroy(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);
    }

    public function destroyPermanent(Produk $produk)
    {
        $toko = $this->getToko();
        abort_if($produk->toko_id !== $toko->id, 403);
    }
}