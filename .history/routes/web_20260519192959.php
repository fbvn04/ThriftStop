<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', fn() => view('welcome'));

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', fn() => view('auth.register'))->name('register');