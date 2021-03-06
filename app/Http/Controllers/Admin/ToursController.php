<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BladeHelper;
use App\Helpers\TourHelper;
use App\Http\CBRAgent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ToursRequest;
use App\Models\Geo;
use App\Models\GeoRelation;
use App\Models\Points;
use App\Models\Tours;
use App\Models\ToursTags;
use App\Models\ToursTagsRelation;
use App\Models\ToursTagsValues;
use App\Models\Ways;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Mockery\Exception;
use Sunra\PhpSimple\HtmlDomParser;

class ToursController extends Controller
{
    public function index()
    {
        $tours = Tours::select('id', 'title', 'duration', 'url', 'source')->paginate(15);
        return view('admin.tours.index', ['tours' => $tours]);
    }

    public function search(Request $request)
    {
        $text = $request->input('text');

        $coins = Tours::where('title', 'LIKE', '%' . $text . '%')->paginate(15);

        if ($request->ajax()) {
            return Response::json(View::make('admin.tours.search', ['tours' => $coins, 'text' => $text])->render());
        }

        return view('admin.tours.index', ['tours' => $coins, 'text' => $text]);
    }

    public function edit($id)
    {
        $item = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar', 'dates'])->find($id);
        $images = json_decode($item->images);
        return view('admin.tours.form', [
            'types' => ToursTagsValues::where('tag_id', 4)->get(),
            'countries' => Geo::all(),
            'ways' => Ways::where('status', '!=', 'country')->get(),
            'cities' => Points::where('status', 'city')->where('off', 0)->get(),

            'item' => $item,
            'images' => $images,
            'imgFolder' => substr($item->id, 0, 2),
        ]);
    }

    public function delete($request)
    {
        Tours::where('id', $request->get('id'))->delete();
        return redirect('admin/tours')->with('message', 'Тур успешно удален');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $country = $data['country'];
        $tourTypes = $data['tourType'] ?? [];

        unset($data['_token']);
        unset($data['_method']);
        unset($data['files']);
        unset($data['tourType']);
        unset($data['country']);
        unset($data['way']);
        unset($data['cities']);
        
        try {
            Tours::find($id)->update($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }


        // Edit types
        if (count($tourTypes))
            ToursTagsRelation::where([
                'tour_id' => $id,
                'tag_id' => 4,
            ])->delete();

        foreach ($tourTypes as $type) {

            ToursTagsRelation::insert([
                'tour_id' => $id,
                'tag_id' => 4,
                'value' => $type,
                'not_update' => 1
            ]);
        }

        if ($country) {

            GeoRelation::where([
                'sub_id' => $id,
                'sub_ess' => 'tour',
                'par_ess' => 'country',
            ])->delete();

            GeoRelation::insert([
                'sub_id' => $id,
                'sub_ess' => 'tour',
                'par_ess' => 'country',
                'par_id' => $country,
            ]);
        }

        return redirect('admin/tours/' . $id . "/edit")
            ->with('message', 'Тур "' . $request->get('title') . '"успешно обновлен');
    }

    public function create()
    {
        return view('admin.tours.form', [
            'types' => ToursTagsValues::where('tag_id', 4)->get(),
            'countries' => Geo::all(),
            'ways' => Ways::where('status', '!=', 'country')->get(),
            'cities' => Points::where('status', 'city')->where('off', 0)->get(),
        ]);
    }

    public function destroyDate(Request $request)
    {
        $data = $request->all();

        return ToursTagsRelation::where([
            'tour_id' => $data['tour_id'],
            'tag_id' => 2,
            'value' => $data['date'],
        ])->delete();
    }

    public function addDate(Request $request)
    {
        $data = $request->all();

        $res = ToursTagsRelation::insert([
            'tour_id' => $data['tour_id'],
            'tag_id' => 2,
            'value' => $data['date'],
        ]);

        if ($res) return 1;
        else return 0;
    }

    public function store(ToursRequest $request)
    {

        $data = $request->all();

        $tourTypes = $data['tourType'] ?? [];
        $country = $data['country'];

        unset($data['_token']);
        unset($data['tourType']);
        unset($data['country']);
        
        

        $tour = new Tours();

        foreach ($data as $key => $value) {
            $tour->$key = $value;
        }

        $tour->save();

        $tour->url = TourHelper::tour2url($tour->title, $tour->id);
        $tour->save();

        foreach ($tourTypes as $type) {
            ToursTagsRelation::insert([
                'tour_id' => $tour->id,
                'tag_id' => 4,
                'value' => $type,
                'not_update' => 1
            ]);
        }

        if ($country) {

            GeoRelation::where([
                'sub_id' => $tour->id,
                'sub_ess' => 'tour',
                'par_ess' => 'country',
            ])->delete();

            GeoRelation::insert([
                'sub_id' => $tour->id,
                'sub_ess' => 'tour',
                'par_ess' => 'country',
                'par_id' => $country,
            ]);
        }

        return redirect('admin/tours/' . $tour->id . "/edit")
            ->with('message', 'Тур добавлен');

    }

    public function parser()
    {
        // Set default tag data_viezda

        if (!ToursTags::where('title', 'data_viezda')->exists()) {
            $newTag = new ToursTags();
            $newTag->title = 'data_viezda';
            $newTag->alias = 'Дата выезда';
            $newTag->save();

            $tagDataId = $newTag->id;
        } else {
            $tag = ToursTags::where('title', 'data_viezda')->select('id')->first();
            $tagDataId = $tag->id;
        }

        // Set default tag travel_type

        if (!ToursTags::where('title', 'travel_type')->exists()) {
            $newTag = new ToursTags();
            $newTag->title = 'travel_type';
            $newTag->alias = 'Способ путешествия';
            $newTag->save();

            $tagTravelId = $newTag->id;
        } else {
            $tag = ToursTags::where('title', 'travel_type')->select('id')->first();
            $tagTravelId = $tag->id;
        }

        // Get all wat for foreach

        $ways = Ways::where(function ($query) {
            $query->where('off', 0)->orWhereNull('off');
        })->where('id', '>', 3)->get();

        foreach ($ways as $way) {
            echo " — — — — — — Parce way - " . $way['title'] . " — — — — — — <br>";
            $parsingPage = file_get_contents('https://magturyview.ru/mday.php?id=' . $way['id']);

            $html = HtmlDomParser::str_get_html(iconv('windows-1251', 'UTF-8//IGNORE', $parsingPage));


            foreach ($html->find('table') as $table) {

                try {
                    $a = $table->find('h3.pr_name a');
                    $href = $a[0]->href;
                } catch (Exception $e) {
                    die(var_dump($e));
                }

                preg_match('/viewprog=(\d{1,10})/', $href, $matches);
                $id = $matches[1];


                /* — — — — — — PARS DATA — — — — — — */

                // Paps NAME
                $name = $a[0]->plaintext;

                // DURATION
                preg_match('/(\d{1,2})[ ](дня|дней)/', $name, $matches);

                if ($matches) {
                    $duration = $matches[1];
                } else {
                    $duration = 1;
                }

                // TRAVEL TYPE
                preg_match_all('/(ж\/д)|(авиа)|(автобус)/', $name, $matches);

                if (count($matches[0])) {

                    ToursTagsRelation::join('tours_tags AS tt', 'tt.id', '=', 'tag_id')
                        ->where('tour_id', $id)
                        ->where('tt.title', 'travel_type')
                        ->delete();
                }

                foreach ($matches[0] as $travel_type) {

                    if ($travel_type) {
                        $newTagRel = new ToursTagsRelation();
                        $newTagRel->tour_id = $id;
                        $newTagRel->tag_id = $tagTravelId;
                        $newTagRel->value = $travel_type;
                        $newTagRel->save();
                    }
                }

                // WAY POINTS

                $routeBlock = $table->find('.smalldef', 1);

                unset($matches);

                if ($routeBlock) preg_match('/Маршрут: (.*)/u', $routeBlock->plaintext, $matches);

                if (isset($matches[1]) && !empty($matches[1]) && count($matches[1])) {

                    $route = $matches[1];

                    try {
                        $routePoints = explode('-->', $matches[1]);
                    } catch (Exception $e) {
                        echo $e . "<br> on ";
                        var_dump($matches);
                    }

                } else {
                    preg_match_all('/((?:([А-ЯЁ][а-яё«»]+[ ]?){1,2}([А-ЯЁа-яё«».]+[ ]?)?[-|–|—|+][ ]?)+[ ]?([.А-ЯЁа-яё«»]+[ ]?)+)/u', $name, $matches);

                    if (isset($matches[0][0]) && $matches[0][0]) {

                        $route = $matches[0][0];

                        $routePoints = preg_split('/[ ]?[-|–|—|+]{1}[ ]?/u', $matches[0][0]);

                    } else {
                        $routePoints = array();
                    }

                }

                if (count($routePoints)) {

                    GeoRelation::where('sub_ess', 'tour')
                        ->where('sub_id', $id)
                        ->where('par_id', 'point')
                        ->delete();
                }

                $pointOrder = 0;

                foreach ($routePoints as $point) {
                    $point = trim($point);

                    $existPoint = Points::where('title', $point)->select('id')->first();
                    if ($existPoint) {
                        $pointId = $existPoint->id;
                    } else {

                        $newPoint = new Points();
                        $newPoint->title = $point;
                        $newPoint->url = \Slug::make($point);
                        $newPoint->save();
                        $pointId = $newPoint->id;

                    }

                    if (!GeoRelation::where('sub_ess', 'point')
                        ->where('par_ess', 'way')
                        ->where('sub_id', $pointId)
                        ->where('par_id', $way->id)
                        ->exists()
                    ) {
                        // Add geo relation way->point
                        $geoRel = new GeoRelation();

                        $geoRel->sub_ess = 'point';
                        $geoRel->par_ess = 'way';
                        $geoRel->sub_id = $pointId;
                        $geoRel->par_id = $way->id;

                        $geoRel->save();
                    }
                    // Add geo relation point->tour
                    // Можно не удалять все точки перед парсингом а проверять перед вставкой на существование
                    $geoRel = new GeoRelation();

                    $geoRel->sub_ess = 'tour';
                    $geoRel->par_ess = 'point';
                    $geoRel->sub_id = $id;
                    $geoRel->par_id = $pointId;
                    $geoRel->order = $pointOrder;
                    $geoRel->save();

                    $pointOrder++;
                }

                // Small description
                $smalldef = $table->find('.smalldef');
                $desc = $smalldef[0]->plaintext;

                // data_viezda
                $data_viezda_html = $table->find('tr', 3);


                preg_match_all('/[\d]{1,2}.[\d]{1,2}.[\d]{2,4}/', $data_viezda_html, $matchesDate);

                if (count($matchesDate[0])) {

                    ToursTagsRelation::join('tours_tags AS tt', 'tt.id', '=', 'tag_id')
                        ->where('tour_id', $id)
                        ->where('tt.title', 'data_viezda')
                        ->delete();

                    foreach ($matchesDate[0] as $dateIn) {
                        $data_viezda = strtotime($dateIn);

                        $newTagRel = new ToursTagsRelation();

                        $newTagRel->tour_id = $id;
                        $newTagRel->tag_id = $tagDataId;
                        $newTagRel->value = $data_viezda;

                        $newTagRel->save();
                    }

                }

                // Min price
                preg_match('/(\d{3,6}) ?(руб|usd|eur)/ui', $desc, $matchesPrice);

                if (isset($matchesPrice[1]) && $matchesPrice[1]) {

                    $cbr = new CBRAgent();

                    if ($matchesPrice[2] == 'usd') {
                        if ($cbr->load()) {
                            $minPrice = $cbr->get('USD') * $matchesPrice[1];
                        } else {
                            $minPrice = 58 * $matchesPrice[1];
                        }

                    } elseif ($matchesPrice[2] == 'eur') {
                        if ($cbr->load()) {
                            $minPrice = $cbr->get('EUR') * $matchesPrice[1];
                        } else {
                            $minPrice = 68 * $matchesPrice[1];
                        }
                    } else {
                        $minPrice = $matchesPrice[1];
                    }

                } else {
                    $minPrice = 0;
                }

                // If tour already exist

                if (Tours::find($id)) {

                    $existTour = Tours::find($id);
                    $existTour->price = $minPrice;
                    $existTour->title = TourHelper::cutTourName(htmlspecialchars($name));
                    $existTour->duration = $duration;
                    $existTour->save();

                    if (!GeoRelation::where('sub_ess', 'tour')
                        ->where('par_ess', 'way')
                        ->where('sub_id', $id)
                        ->where('par_id', $way->id)
                        ->exists()
                    ) {
                        // Add geo relation way->tour
                        $geoRel = new GeoRelation();

                        $geoRel->sub_ess = 'tour';
                        $geoRel->par_ess = 'way';
                        $geoRel->sub_id = $id;
                        $geoRel->par_id = $way->id;

                        $geoRel->save();
                    }
                    echo "Update " . $id . "<br>";
                    continue;
                }

                // Get full tour page
                $parcingSinglePage = file_get_contents('https://magturyview.ru/mday.php' . $href);
                $singlePage = HtmlDomParser::str_get_html(iconv("windows-1251", "utf-8", $parcingSinglePage));


                $head = $singlePage->find('head', 0);
                $head->outertext = '';

                $body = $singlePage->find('body');

                // Cleare for text
                $h = $body[0]->find('h1');
                $h[0]->outertext = '';

                $singlePageTable = $body[0]->find('table');
                $singlePageTable[0]->outertext = '';

                // — — — COPY IMAGE — — — \\

                $imagesArr = [];

                foreach ($singlePageTable[1]->find('a') as $link) {

                    if ($link->href) {

                        $img = $link->href;
                        $img = preg_replace('/http:\/\/89.108.70.76/', 'https://magput.ru', $img);

                        preg_match('/([\da-z]+)\.(png|jpg|jpeg|gif)/ui', $img, $matches);
                        if (!isset($matches[1]) || empty($matches[1])) {
                            echo "could not get image name " . $img . "<br>\n";
                            continue;
                        }

                        $gd = @imagecreatefromstring(file_get_contents($img));
                        if ($gd === false) {
                            echo 'Image is corrupted<br>';
                            continue;
                        }

                        $folder = substr($id, 0, 2);
                        $imageName = $matches[1] . '.' . $matches[2];

                        if (!is_dir(base_path('/public/img/tours/full/' . $folder))) {
                            mkdir(base_path('/public/img/tours/full/' . $folder));
                        }
                        $path = base_path('/public/img/tours/full/' . $folder . '/' . $imageName);

                        if (!file_exists(base_path('/public/img/tours/full/' . $folder . '/' . $imageName))) {
                            $workingImage = Image::make($img);
                            $workingImage->flip();
                            $workingImage->save($path);
                        }

                        $imagesArr[] = $imageName;
                    }
                }

                $images = json_encode($imagesArr);

                // — — — COPY IMAGE END— — — \\

                // Clear further

                $singlePageTable[1]->outertext = '';

                $singlePageHr = $body[0]->find('hr');
                $singlePageHr[0]->outertext = '';
                $singlePageHr[1]->outertext = '';

                $text = $singlePage->save();

                $blockTextParcing = HtmlDomParser::str_get_html($text);

                $bodyBlockNode = $blockTextParcing->find('body', 0);
                $text = $bodyBlockNode->innertext;

                // Min price

                if (!$minPrice) {

                    preg_match('/(\d{0,3}\s?\d{3,6}) ?(руб|usd|eur)/ui', $text, $matchesPrice);
                    if (isset($matchesPrice[1]) && $matchesPrice[1]) {

                        $cbr = new CBRAgent();

                        if ($matchesPrice[2] == 'usd') {
                            if ($cbr->load()) {
                                $minPrice = $cbr->get('USD') * $matchesPrice[1];
                            } else {
                                $minPrice = 58 * $matchesPrice[1];
                            }

                        } elseif ($matchesPrice[2] == 'eur') {
                            if ($cbr->load()) {
                                $minPrice = $cbr->get('EUR') * $matchesPrice[1];
                            } else {
                                $minPrice = 68 * $matchesPrice[1];
                            }
                        } else {
                            $minPrice = $matchesPrice[1];
                        }
                    }


                }

                // VALIDATION

                if (mb_strlen($name) > 250) {
                    $name = mb_strimwidth($name, 0, 250);
                }

                $text = preg_replace("!<a.*?href=\"?'? ?([^ \"'>]+)\"?'?.*?>(.*?)<\/a>!is", "\\2", $text);
                $text = preg_replace('/style=\"[^\"]+\"/ui', "\\", $text);
                $text = preg_replace('/class=\'[^\"]+\'/ui', "\\", $text);

                // Add row tour
                $newTour = new Tours();

                $newTour->id = $id;
                $newTour->title = TourHelper::cutTourName(htmlspecialchars($name));
                $newTour->description = $desc;
                $newTour->text = $text;
                $newTour->url = TourHelper::tour2url($name, $id);
                $newTour->price = str_replace(' ', '', $minPrice);;
                $newTour->duration = $duration;
                $newTour->source = 'magput';
                $newTour->images = $images;

                $newTour->save();

                // Logging
                echo "Add " . $id . "<br>";

            }
        }

    }

    public function show(Request $request, $id)
    {
        $action = camel_case($id);
        if (method_exists($this, $action)) {
            return $this->$action($request);
        }
        return abort(404);
    }

    public function getImages(Request $request)
    {
        $tour = Tours::find($request->id);
        $dropzone = [];

        foreach (json_decode($tour->images) as $image) {

            $filePath = public_path(config('main.imgPath.tour') . 'full/' . substr($tour->id, 0, 2) . '/' . $image);

            if (File::exists($filePath)) {

                $obj = [];

                $obj['name'] = $image;
                $obj['size'] = File::size($filePath);
                $obj['thumb'] = BladeHelper::tourThumb($image, $tour->id);

                $dropzone[] = $obj;
            } else {
                $obj = [];
                
                $obj['name'] = $image;
                $obj['size'] = 0;
                $obj['thumb'] = null;
                
                $dropzone[] = $obj;
            }

        }
        return json_encode($dropzone);
    }

    public function uploadImage(Request $request)
    {

        $image = $request->file('file');
        $imgObj = Image::make($image);
        $imageName = time() . '.jpg';
        $tour = Tours::find($request->tourId);

        $folderFullPath = public_path('img/tours/full/' . substr($tour->id, 0, 2));

        if (!File::exists($folderFullPath)) {
            File::makeDirectory($folderFullPath, $mode = 0777, true, true);
        }

        if ($imgObj->width() > 600) {

            $imgObj->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderFullPath . '/' . $imageName, 100);

        $folderThumbPath = public_path('img/tours/thumbs/' . substr($tour->id, 0, 2));

        if (!File::exists($folderThumbPath)) {
            File::makeDirectory($folderThumbPath, $mode = 0777, true, true);
        }

        if ($imgObj->height() > 235) {

            $imgObj->resize(null, 235, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderThumbPath . '/' . $imageName, 75);

        $imagesList = $tour->images ? json_decode($tour->images, true) : [];
        $imagesList[] = $imageName;
        $tour->images = json_encode($imagesList);


        if ($tour->save()) {
            return response()->json(['success' => $imageName]);
        } else {
            return response()->json(['error' => 'images not saved', 'success' => 0]);
        }

    }

    public function removeImage(Request $request)
    {

        $tour = Tours::find($request->id);

        $images = json_decode($tour->images, true);

        foreach ($images as $key => $value) {
            if ($value == $request->name) unset($images[$key]);
        }

        $tour->images = json_encode($images);

        if ($tour->save()) {
            File::delete(public_path(config('main.imgPath.tour') . 'full/' . substr($tour->id, 0, 2) . '/' . $request->name));
            File::delete(public_path(config('main.imgPath.tour') . 'thumbs/' . substr($tour->id, 0, 2) . '/' . $request->name));
        }
    }
}