<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 18.04.2018
 * Time: 12:22
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function sanatorii(){
        return view('front.pages.sanatorii');
    }
}