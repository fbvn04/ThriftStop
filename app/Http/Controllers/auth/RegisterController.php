<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showBuyerRegister()
    {
        return view('auth.buyer.register');
    }

    public function buyerRegister(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|min:2',
            'username'  => 'required|string|min:3|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'hp'        => 'required|numeric|digits_between:8,13',
            'password'  => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'hp'        => $request->hp,
            'password'  => Hash::make($request->password),
            'role'      => 'buyer',
        ]);

        return redirect()->route('login.buyer')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
    public function showSellerRegister()
    {
        return view('auth.seller.register');
    }

    public function sellerRegister(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|min:2',
            'nama_toko' => 'required|string|min:3|max:50|unique:tokos,nama_toko',
            'username'  => 'required|string|min:3|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'hp'        => 'required|numeric|digits_between:8,13',
            'password'  => 'required|min:8|confirmed',
        ]);
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'      => $request->nama,
                'username'  => $request->username,
                'email'     => $request->email,
                'hp'        => $request->hp,
                'password'  => Hash::make($request->password),
                'role'      => 'seller',
            ]);

            Toko::create([
                'nama_toko' => $request->nama_toko,
                'user_id' => $user->id,
            ]);
        });
        return redirect()->route('login.seller')->with('success', 'Akun seller berhasil dibuat! Silakan login.');
    }
}
