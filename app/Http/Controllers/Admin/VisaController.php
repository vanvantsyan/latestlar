<?php

namespace App\Http\Controllers\Admin;

use App\Models\Geo;
use App\Models\Visa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visas = Visa::select('id', 'country_id', 'time', 'amount')->with('countries')->get();
        return view('admin.visa.index', compact('visas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Geo::all();
        return view('admin.visa.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if(isset($data['add_docs'])) {
            $data['add_docs'] = json_encode($data['add_docs']);
        }
        Visa::create($data);

        return redirect('admin/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(!is_numeric($id)){
            $action = camel_case($id);
            if(method_exists($this, $action)){
                return $this->$action($request);
            }
            return abort(404);
        }
        $page = Page::findOrFail($id);
        return view('admin.visa.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visa = Visa::findOrFail($id);
        $visa->amount = intval($visa->amount);
        $visa->add_docs = !empty($visa->add_docs) ? json_decode($visa->add_docs) : [];
        $countries = Geo::all();
        return view('admin.visa.create', [
            'visa' => $visa,
            'countries' => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $visa = Visa::findOrFail($id);
        $data = $request->all();
        if(isset($data['add_docs'])) {
            $data['add_docs'] = json_encode($data['add_docs']);
        }
        $visa->fill($data);
        $visa->save();

        return redirect('admin/visa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }


    public function delete($request){

        Visa::where('id', $request->get('id'))->delete();
        return redirect('admin/visa')
            ->with('message', 'Страница успешно удалена');

    }


}
