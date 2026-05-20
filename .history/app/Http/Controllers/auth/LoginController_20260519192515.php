<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
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
            $request->session()->regenerate(); // Cegah session fixation

            return redirect()->intended('/dashboard'); // Ganti sesuai halaman utama
        }

        // Kalau gagal, kembalikan ke login dengan pesan error
        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password salah.');
    }
}