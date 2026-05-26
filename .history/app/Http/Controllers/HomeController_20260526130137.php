<?php

namespace App\Http\HomeController;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('buyer.home', [
            'user' => auth()->user(),
        ]);
    }
}