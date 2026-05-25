<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegionController;


//API THRIFTSTOP
Route::get('/ping', function () {
    return response()->json(['ok' => true]);
});
Route::get('/region-indo/provinsi', [RegionController::class, 'provinsi']);
Route::get('/region-indo/kota/{id}', [RegionController::class, 'kota']);
Route::get('/region-indo/kecamatan/{id}', [RegionController::class, 'kecamatan']);
