<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tours;
use App\Models\Worldparts;
use App\Models\Ways;

class ToursController extends Controller
{
    public function index()
    {
        return view('admin.tours.index', ['tours' => Tours::all()]);
    }

    public function parser()
    {

    }

}