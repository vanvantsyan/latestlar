<?php

namespace App\Http\Controllers\Front;

use App\Models\Points;
use App\Models\Tours;
use App\Http\Controllers\Controller;
use App\Helpers\BladeHelper;

use App\Models\ToursTagsRelation;
use App\Models\ToursTagsValues;
use App\Models\Ways;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

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
    public function unit($country = 'russia', $action, $url)
    {
        preg_match('/[\d]{3,8}/', $url, $extractId);

        if (count($extractId)) {
            $id = $extractId[0];
        } else {
            $id = '2070';
        }

//        $tour = Tours::findOrFail($id);
//        dd($tour);

        return view('front.tours.tour', ['tour' => Tours::findOrFail($id)]);
    }

    /**
     * Display list of country by get parameters
     */
    public function country(Tours $tours, $country)
    {
        $list = $tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])
            ->leftJoin('geo_relation AS g_rel', function ($query) {
                $query
                    ->on('tours.id', '=', 'g_rel.sub_id')
                    ->where('g_rel.sub_ess', '=', 'tour')
                    ->where('g_rel.par_ess', '=', 'country');

            })->leftJoin('geo_countries AS countries', 'countries.id', '=', 'g_rel.par_id')
            ->where('countries.slug', $country)
            ->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration');

        $countTours = $list->count();

        $tours = $list->take(15)->get();

        $tourTypes = ToursTagsValues::where('tag_id', 4)->get();

        $cities = Points::where('status', 'city')->where('off', 0)->take(10)->get();

        $citiesGolden = Points::with(['geoRelationSub' => function ($query) {
            $query->where('par_id', 319)->where('par_ess', 'way');
        }])->where('off', 0)->take(10)->get();

        $countries = Ways::where('status','country')->take(10)->get();

        return view('front.tours.tours', [
            'tours' => $tours->toArray(),
            'country' => $country,
            'tourTypes' => $tourTypes,
            'countTours' => $countTours,
            'cities' => $cities,
            'citiesGolden' => $citiesGolden,
            'countries' => $countries
        ]);
    }

    /**
     * Display list of country by get parameters
     */
    public function list(Tours $tours)
    {
        $list = $tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);
        $countTours = $list->count();
        $tours = $list->take(15)->get();

        $tourTypes = ToursTagsValues::where('tag_id', 4)->get();

        $cities = Points::where('status', 'city')->where('off', 0)->take(10)->get();

        $citiesGolden = Points::with(['geoRelationSub' => function ($query) {
            $query->where('par_id', 319)->where('par_ess', 'way');
        }])->where('off', 0)->take(10)->get();

        $countries = Ways::where('status','country')->take(10)->get();

        return view('front.tours.tours', [
            'tours' => $tours->toArray(),
            'country' => '',
            'tourTypes' => $tourTypes,
            'countTours' => $countTours,
            'cities' => $cities,
            'citiesGolden' => $citiesGolden,
            'countries' => $countries
        ]);
    }

    public function getMore(Request $request)
    {
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration', DB::raw('COUNT(tours.id) as countDate'), 'ttrDate.tour_id');

        $limit = $request->input('limit');
        $offset = $request->input('offset');

        $tours = $this->applyFilters($tours, $request->input('params'));

        $tours->groupBy('tours.id');

        $tours->skip($offset)->take($limit);

        $list = $tours->get();

        return view('front.tours.more', ['tours' => $list->toArray()]);
    }

    public function getCount(Request $request)
    {
        $tours = Tours::select('tours.id');
        $tours = $this->applyFilters($tours, $request->all());
        $tours->groupBy('tours.id');

        return count($tours->get()->toArray());
    }

    public function filters(Request $request)
    {
        $tours = Tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar']);

        $tours = $this->applyFilters($tours, $request->all());

        $tours->select('tours.id', 'tours.title', 'tours.description', 'tours.price', 'tours.url', 'tours.images', 'tours.duration', 'ttrDate.tour_id');

        $limit = $request->input('limit', 15);
        $offset = $request->input('offset', 0);

        $tours->groupBy('tours.id');

        $tours->skip($offset)->take($limit);
        $list = $tours->get();

        if ($list->count()) {
            return view('front.tours.more', ['tours' => $list->toArray()]);
        } else {
            return view('front.tours.empty');
        };
    }

    public function applyFilters($tours, $filters)
    {
        if ($country = array_get($filters, 'country', null)) {
            $tours->leftJoin('geo_relation AS g_rel', function ($query) {
                $query->on('g_rel.sub_id', '=', 'tours.id')
                    ->where('sub_ess', '=', 'tour')
                    ->where('par_ess', '=', 'country');
            });
            $tours->leftJoin('geo_countries AS countries', 'countries.id', '=', 'g_rel.par_id');
            $tours->where('countries.slug', $country);
        }

        if ($tourType = array_get($filters, 'tourType', null)) {
            $tours->leftJoin('tour_tags_relations AS ttrType', function ($query) {
                $query->on('ttrType.tour_id', '=', 'tours.id')
                    ->where('ttrType.tag_id', '=', 4);
            })->where('ttrType.value', $tourType);
        }

        if ($priceFrom = array_get($filters, 'priceFrom', null)) {
            $tours->where('tours.price', '>=', $priceFrom);
        }
        if ($priceTo = array_get($filters, 'priceTo', null)) {
            $tours->where('tours.price', '<=', $priceTo);
        }

        if ($tourDate = array_get($filters, 'tourDate', null)) {

            $dateArr = explode('-', $tourDate);
            $dateFrom = trim(head($dateArr));
            $dateTo = trim(last($dateArr));

            $dateRelation = ToursTagsRelation::join('tours', 'tours.id', '=', 'tour_tags_relations.tour_id', 'right outer')
                ->where(function ($query) use ($dateFrom, $dateTo) {
                    $query->where(function ($query) use ($dateFrom, $dateTo) {
                        $query->where('tour_tags_relations.value', '>=', strtotime($dateFrom))
                            ->where('tour_tags_relations.value', '<=', strtotime($dateTo));
                    });//->orWhereNull('tour_tags_relations.value');
                })->pluck('tours.id')->toArray();

            //->pluck('tours.id','tour_tags_relations.value');
            //->groupBy('tours.id')->pluck('tours.id')->toArray();

            $tours->leftJoin('tour_tags_relations AS ttrDate', function ($query) use ($dateFrom, $dateTo, $dateRelation) {
                $query->on('ttrDate.tour_id', '=', 'tours.id')
                    ->where('ttrDate.tag_id', '=', 2);
            })->whereIn('ttrDate.tour_id', $dateRelation);

//            $tours->addSelect('ttrDate.value','ttrDate.tour_id');
//            $tours->orderBy('ttrDate.value', "DESC");
        }

        if ($tourPoint = array_get($filters, 'tourPoint', null)) {

            $point = Points::where('title', $tourPoint)->select('id')->first();

            $tours->leftJoin('geo_relation AS geo_r', function ($query) {
                $query->on('geo_r.sub_id', '=', 'tours.id')
                    ->where('geo_r.sub_ess', 'tour')
                    ->where('geo_r.par_ess', 'point');
            })->where('geo_r.par_id', $point->id);
        }

        if ($sort = array_get($filters, 'sort', null)) {
            $sortArr = explode('-', $sort);

            $tours->orderBy('tours.' . head($sortArr), last($sortArr));
        }

        $durationFrom = array_get($filters, 'durationFrom', null);
        $durationTo = array_get($filters, 'durationTo', null);

        if ($durationFrom) $tours->where('duration', '>', $durationFrom);
        if ($durationTo) $tours->where('duration', '<', $durationTo);

        return $tours;
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        $results = array();

        $queries = DB::table('points')
            ->where('title', 'LIKE', '%' . $term . '%')
            ->take(5)->get();

        foreach ($queries as $query) {
            $results[] = ['id' => $query->id, 'value' => $query->title];
        }
        return Response::json($results);
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

        $folderFullPath = public_path('img\tours\full/' . substr($tour->id, 0, 2));

        if (!File::exists($folderFullPath)) {
            File::makeDirectory($folderFullPath, $mode = 0777, true, true);
        }

        if ($imgObj->width() > 600) {

            $imgObj->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderFullPath . '/' . $imageName, 100);

        $folderThumbPath = public_path('img\tours\thumbs/' . substr($tour->id, 0, 2));

        if (!File::exists($folderThumbPath)) {
            File::makeDirectory($folderThumbPath, $mode = 0777, true, true);
        }

        if ($imgObj->height() > 235) {

            $imgObj->resize(null, 235, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save($folderThumbPath . '/' . $imageName, 75);

        $imagesList = get_object_vars(json_decode($tour->images));
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
        $images = get_object_vars(json_decode($tour->images));

        foreach ($images as $key => $value) {
            if ($value == $request->name) unset($images[$key]);
        }

        $tour->images = json_encode($images);

        if ($tour->save()) {
            File::delete(public_path(config('main.imgPath.tour') . 'full/' . substr($tour->id, 0, 2) . '/' . $request->name));
            File::delete(public_path(config('main.imgPath.tour') . 'thumbs/' . substr($tour->id, 0, 2) . '/' . $request->name));
        }
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
