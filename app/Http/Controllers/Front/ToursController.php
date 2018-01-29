<?php

namespace App\Http\Controllers\Front;

use App\Models\Tours;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */
    public function show(Tours $tours, $id)
    {
        return view('front.tours.tour', ['tour' => $tours::findOrFail($id)]);
    }

    /**
     * Display list of country by get parameters
     */
    public function country(Tours $tours, $country)
    {
        return view('front.tours.country', ['tours' => $tours::all()]);
    }

    /**
     * Display list of country by get parameters
     */
    public function list(Tours $tours)
    {
        $list = $tours::with(['tourTags', 'tourGeoSub'])->take(2)->get();
        return view('front.tours.tours', ['tours' => $list]);
    }

    public function getMore(Tours $tours){
        $list = $tours::with(['tourTags', 'tourGeoSub'])->take(15)->get();
        return view('front.tours.more',['tours' => $list]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */
    public function edit(Tours $tours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tours $tours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tours $tours
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tours $tours)
    {
        //
    }
}
