<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TourHelper;
use App\Models\GeoRelation;
use App\Models\Points;
use App\Models\ToursTagsRelation;
use App\Models\ToursTagsValues;
use App\Models\waysTags;
use App\Models\waysTagsRelation;
use App\Models\Ways;
use App\Models\Worldparts;
use App\Http\CBRAgent;
use Illuminate\Support\Facades\Artisan;
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

    public function insert(Request $request, $id = null){

        if(!$id) {
            Artisan::call('tours:start', [
                'action' => 'relateWithTypes',
            ]);
        } else {

            $type = ToursTagsValues::find($id);

            // Удаляю все связи подобного типа где нет not_update
            ToursTagsRelation::where('tag_id', 4)->where('value', $type->id)->where('not_update', 0)->delete();

            if ($type->keys) {

                echo "--- Тег " . $type->alias . " ---\n";


                /* Получаем ключи для запроса */

                $toursQuery = Tours::select('id');

                $keys = explode(',', $type->keys);

                foreach ($keys as $key) {
                    if ($key) {
                        $toursQuery->orWhere('title', 'like', '%' . $key . '%');
                        $toursQuery->orWhere('description', 'like', '%' . $key . '%');
                    }
                }

                $toursIds = $toursQuery->pluck('id');


                /* Собираем данные для вставки связей */

                $arr = [];

                foreach ($toursIds as $id) {
                    $arr[] = [
                        'tour_id' => $id,
                        'value' => $type->id,
                        'tag_id' => 4
                    ];
                }

                // Вставляем данные
                ToursTagsRelation::insert($arr);
            }
        }

        return redirect('admin/types/')
            ->with('message', 'Теги проставлены');
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