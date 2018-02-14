<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TourHelper;
use App\Models\GeoRelation;
use App\Models\Points;
use App\Models\waysTags;
use App\Models\waysTagsRelation;
use App\Models\Ways;
use App\Models\Worldparts;
use App\Http\CBRAgent;
use Intervention\Image\Facades\Image;
use Sunra\PhpSimple\HtmlDomParser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Mockery\Exception;

class WaysController extends Controller
{
    public function index()
    {
        $units = Ways::select('id', 'title', 'url', 'status')->get();
        return view('admin.ways.index', ['units' => $units]);
    }

    public function edit($id)
    {
        $item = Ways::find($id);
        $images = json_decode($item->images);
        return view('admin.ways.form', [
            'item' => $item,
            'images' => $images,
            'imgFolder' => substr($item->id, 0 , 2),
        ]);
    }

    public function delete($request){

        Ways::where('id', $request->get('id'))->delete();
        return redirect('admin/ways')
            ->with('message', 'Тур успешно удален');

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        unset($data['files']);

        Ways::where('id', $id)->update($data);
        return redirect('admin/ways')
            ->with('message', 'Направление "'.$request->get('title').'" успешно обновлено');
    }

    public function create()
    {
        $categories = Ways::all();
        return view('admin.ways.form', [
            'categories' => $categories
        ]);
    }

    public function show(Request $request, $id)
    {
        $action = camel_case($id);
        if (method_exists($this, $action)) {
            return $this->$action($request);
        }
        return abort(404);
    }
}