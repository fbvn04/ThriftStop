<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function checkout()
{
    $user = auth()->user();

    $items = Cart::with('product')
        ->where('user_id', $user->id)
        ->get();

    return view('buyer.checkout', compact(
        'user',
        'items'
    ));
    }

    public function increaseQty($id)
{
    $cart = Cart::findOrFail($id);

    $cart->qty += 1;
    $cart->save();

    return back();
    }

    public function decreaseQty($id)
{
    $cart = Cart::findOrFail($id);

    if ($cart->qty > 1) {
        $cart->qty -= 1;
        $cart->save();
    }

    return back();
    }

    public function akun()
{
    $user = auth()->user();

    return view('buyer.akun', compact('user'));
    }

    public function editProfile()
{
    $user = Auth::user();

    return view('buyer.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required',
        'phone' => 'nullable',
        'address' => 'nullable',
        'birth_date' => 'nullable|date',
        'gender' => 'nullable',
        'photo' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('photo')) {

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->photo = $request->file('photo')
            ->store('profile', 'public');
    }

    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->birth_date = $request->birth_date;
    $user->gender = $request->gender;

    $user->save();

    return redirect()
        ->route('buyer.akun')
        ->with('success', 'Profile berhasil diperbarui');
        }
}