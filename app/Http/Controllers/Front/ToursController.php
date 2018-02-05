<?php

namespace App\Http\Controllers\Front;

use App\Models\Tours;
use App\Http\Controllers\Controller;
use App\Helpers\BladeHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            })->leftJoin('geo_countries AS countries', 'countries.id','=','g_rel.par_id')
            ->where('countries.slug', $country)
            ->take(15)
            ->select('tours.id','tours.title','tours.description','tours.price','tours.url','tours.images','tours.duration')
            ->get();

//        dd($list->toArray());
        return view('front.tours.tours', ['tours' => $list->toArray()]);
    }

    /**
     * Display list of country by get parameters
     */
    public function list(Tours $tours)
    {
        $list = $tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->take(15)->get();
//        dd($list->toArray());
        return view('front.tours.tours', ['tours' => $list->toArray()]);
    }

    public function getMore(Tours $tours, Request $request)
    {
        $limit = $request->input('limit');
        $offset = $request->input('offset');

        $list = $tours::with(['tourTags.fixValue', 'parPoints.pointsPar', 'parWays.waysPar'])->skip($offset)->take($limit)->get();
        return view('front.tours.more', ['tours' => $list->toArray()]);
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
