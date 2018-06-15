<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PeriodsRequest;
use App\Models\Period;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeriodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periods = Period::all();
        
        return view('admin.periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.periods.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PeriodsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeriodsRequest $request)
    {
        $period = Period::create($request->validated());
        
        return redirect()->route('periods.edit', $period->id)->with('message', 'Период добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Period $period
     * @return \Illuminate\Http\Response
     */
    public function edit(Period $period)
    {
        return view('admin.periods.form', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PeriodsRequest $request
     * @param  Period $period
     * @return \Illuminate\Http\Response
     */
    public function update(PeriodsRequest $request, Period $period)
    {
        $request['title_cases'] = [
            'r' => $request->title_r,
            'd' => $request->title_d,
            'v' => $request->title_v,
            't' => $request->title_t,
            'p' => $request->title_p,
        ];
    
        $period->update($request->validated());

        return redirect()->route('periods.edit', $period->id)->with('message', 'Период сохранен!');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param Period $period
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Period $period)
    {
        $period->delete();

        return redirect('admin/periods')->with('message', 'Период успешно удален');
    }
}
