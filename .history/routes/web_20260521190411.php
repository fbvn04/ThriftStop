<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;

Route::get('/', fn() => view('welcome'));

Route::get('/login',        [LoginController::class, 'indexBuyer'])->name('login.buyer');
Route::get('/seller/login', [LoginController::class, 'indexSeller'])->name('login.seller');
Route::post('/login',       [LoginController::class, 'login'])->name('login.post');

Route::get('/register',  [RegisterController::class, 'showBuyerRegister'])->name('register.buyer');
Route::post('/register', [RegisterController::class, 'buyerRegister'])->name('register.buyer.post');

Route::get('/seller/register',  [RegisterController::class, 'showSellerRegister'])->name('register.seller');
Route::post('/seller/register', [RegisterController::class, 'sellerRegister'])->name('register.seller.post');
Route::get('/produk/{produk}/detail', [ProductController::class, 'detail'])->name('produk.detail');
Route::get('/produk/{produk}/edit',   [ProductController::class, 'edit'])->name('produk.edit');

Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan',   [SellerController::class, 'laporan'])->name('laporan');
    Route::get('/toko',      [SellerController::class, 'toko'])->name('toko');
    Route::get('/orderan',   [SellerController::class, 'orderan'])->name('orderan');

    // ── Kelola Produk (semua pakai ProductController)
    Route::get('/produk',                       [ProductController::class, 'index'])->name('produk');
    Route::post('/produk',                      [ProductController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}',              [ProductController::class, 'show'])->name('produk.show');
    Route::put('/produk/{produk}',              [ProductController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}',           [ProductController::class, 'destroy'])->name('produk.destroy');
    Route::delete('/produk/{produk}/permanent', [ProductController::class, 'destroyPermanent'])->name('produk.destroy.permanent');

});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');