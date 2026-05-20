<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ✅ Tambah ini
    public function indexBuyer()
    {
        return view('auth.buyer.login');
    }

    public function indexSeller()
    {
        return view('auth.seller.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3',
            'password' => 'required|min:6',
        ], [
            'username.required' => 'Username tidak boleh kosong.',
            'username.min'      => 'Username minimal 3 karakter.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ Ganti redirect by role
            return match(Auth::user()->role) {
                'seller' => redirect()->intended(route('seller.products.index')),
                default  => redirect()->intended(route('buyer.products.index')),
            };
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password salah.');
    }
}