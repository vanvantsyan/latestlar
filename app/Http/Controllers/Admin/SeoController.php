<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SeoRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneratedSeo;

class SeoController extends Controller
{
    public function index(){
        $units = GeneratedSeo::select('id','url')->orderBy('id')->get();
        return view('admin.seo.index', ['units' => $units]);
    }

    public function create() {
        return view('admin.seo.form');
    }

    public function store(SeoRequest $request){

        $data = $request->all();
        unset($data['_token']);
        $data['url'] = preg_replace('~[\S]+.ru\/~i',"", $data['url']);

        GeneratedSeo::insert($data);

        return redirect('admin/seo')->with('message', 'Сео для "'.$request->get('url').'"успешно добавлена');
    }

    public function edit($id)
    {
        $item = GeneratedSeo::find($id);
        return view('admin.seo.form', [
            'item' => $item
        ]);
    }

    public function update(SeoRequest $request, GeneratedSeo $seo)
    {
        $data = $request->all();

        unset($data['_token']);
        unset($data['_method']);

        $data['url'] = preg_replace('~[\S]+.ru\/~i',"", $data['url']);

        $seo->update($data);

        return redirect('admin/seo')
            ->with('message', 'Сео для  "' . $request->get('url') . '"успешно обновлено');
    }

    public function show(Request $request, $id)
    {
        $action = camel_case($id);
        if(method_exists($this, $action)){
            return $this->$action($request);
        }
        return abort(404);
    }

    public function delete($request){

        GeneratedSeo::where('id', $request->get('id'))->delete();
        return redirect('admin/seo')->with('message', 'Сео успешно удалено');

    }


}