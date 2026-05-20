<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', fn() => view('welcome'));

Route::get('/login',        [LoginController::class, 'indexBuyer'])->name('login.buyer');
Route::get('/seller/login', [LoginController::class, 'indexSeller'])->name('login.seller');
Route::post('/login',       [LoginController::class, 'login'])->name('login.post');

Route::get('/register', fn() => view('auth.register'))->name('register');