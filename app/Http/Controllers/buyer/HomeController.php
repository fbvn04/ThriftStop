<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('buyer.home', [
            'user' => auth()->user(),
        ]);
    }

    public function shop()
{
    $products = Product::aktif()
        ->with('toko')
        ->latest()
        ->paginate(12);

    return view('buyer.shop', [
        'user' => auth()->user(),
        'products' => $products,
    ]);
    }

    public function detailProduk($id)
{
    $product = Product::with('toko')->findOrFail($id);

    return view('buyer.detail-produk', [
        'user' => auth()->user(),
        'product' => $product,
    ]);
    }

    public function addToCart($id)
{
    $cart = Cart::where('user_id', auth()->id())
        ->where('product_id', $id)
        ->first();

    if ($cart) {

        $cart->increment('qty');

    } else {

        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'qty' => 1,
        ]);

    }

    return redirect()
        ->route('buyer.keranjang')
        ->with('success','Produk ditambahkan');
        }

public function cart()
{
    $items = Cart::with('product')
        ->where('user_id', auth()->id())
        ->get();

    return view('buyer.cart',[
        'user' => auth()->user(),
        'items' => $items,
    ]);
    }
}