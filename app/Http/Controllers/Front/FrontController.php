<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    // Main site page
    public function index()
    {
        return view('front.face');
    }


}
