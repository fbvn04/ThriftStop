<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', fn() => view('welcome'));

Route::get('/login',        [LoginController::class, 'indexBuyer'])->name('login.buyer');
Route::get('/seller/login', [LoginController::class, 'indexSeller'])->name('login.seller');
Route::post('/login',       [LoginController::class, 'login'])->name('login.post');

Route::get('/register',  [RegisterController::class, 'showBuyerRegister'])->name('register.buyer');
Route::post('/register', [RegisterController::class, 'buyerRegister'])->name('register.buyer.post');