<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TourHelper;
use App\Models\GeoRelation;
use App\Models\Points;
use App\Models\ToursTagsValues;
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

class TypesController extends Controller
{
    public function index()
    {
        $units = ToursTagsValues::select('id', 'alias', 'value')->get();
        return view('admin.types.index', ['units' => $units]);
    }

    public function edit($id)
    {
        $item = ToursTagsValues::find($id);
        $images = json_decode($item->images);
        return view('admin.types.form', [
            'item' => $item,
            'images' => $images,
            'imgFolder' => substr($item->id, 0, 2),
        ]);
    }

    public function delete($request)
    {

        ToursTagsValues::where('id', $request->get('id'))->delete();
        return redirect('admin/types')
            ->with('message', 'Тип успешно удален');

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        unset($data['files']);

        ToursTagsValues::where('id', $id)->update($data);
        return redirect('admin/types/' . $id . '/edit')
            ->with('message', 'Тип "' . $request->get('alias') . '" успешно обновлен');
    }

    public function create()
    {
        return "";
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