<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SellerController;

Route::get('/', fn() => view('welcome'));

Route::get('/login',        [LoginController::class, 'indexBuyer'])->name('login.buyer');
Route::get('/seller/login', [LoginController::class, 'indexSeller'])->name('login.seller');
Route::post('/login',       [LoginController::class, 'login'])->name('login.post');

Route::get('/register',  [RegisterController::class, 'showBuyerRegister'])->name('register.buyer');
Route::post('/register', [RegisterController::class, 'buyerRegister'])->name('register.buyer.post');

Route::get('/seller/register',  [RegisterController::class, 'showSellerRegister'])->name('register.seller');
Route::post('/seller/register', [RegisterController::class, 'sellerRegister'])->name('register.seller.post');

Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/produk',    [SellerController::class, 'produk'])->name('produk');
    Route::get('/laporan',   [SellerController::class, 'laporan'])->name('laporan');
    Route::get('/toko',      [SellerController::class, 'toko'])->name('toko');
    Route::get('/orderan',   [SellerController::class, 'orderan'])->name('orderan');
});