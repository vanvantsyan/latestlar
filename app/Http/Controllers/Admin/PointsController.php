<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PointsRequest;
use App\Models\Points;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PointsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = Points::paginate(15);
        
        return view('admin.points.index', compact('points'));
    }

    /**
     * Search by string.
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Throwable
     */
    public function search(Request $request)
    {
        $text = $request->input('text');

        $points = Points::where('title', 'LIKE', '%' . $text . '%')->paginate(15);

        if ($request->ajax()) {
            return response()->json(view('admin.points.search', ['points' => $points, 'text' => $text])->render());
        }

        return view('admin.points.index', ['points' => $points, 'text' => $text]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.points.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PointsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PointsRequest $request)
    {
        $point = Points::create($request->validated());
        
        return redirect()->route('points.edit', $point->id)->with('message', 'Точка маршрута добавлен');
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
     * @param  Points $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Points $point)
    {
        return view('admin.points.form', compact('point'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PointsRequest  $request
     * @param  Points  $point
     * @return \Illuminate\Http\Response
     */
    public function update(PointsRequest $request, Points $point)
    {
        $point->update($request->validated());

        return redirect()->route('points.edit', $point->id)->with('message', 'Точка маршрута сохранена!');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param Points $point
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Points $point)
    {
        $point->delete();

        return redirect('admin/points')->with('message', 'Период успешно удален');
    }
}
