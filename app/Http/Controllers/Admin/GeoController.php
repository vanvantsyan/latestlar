<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Geo;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class GeoController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = new Geo();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = $this->model->select('id', 'country', 'slug')->get();
        return view('admin.geo.index', [
            'countries' => $countries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.geo.add_countries');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCountries($request);
        $this->model->saveCountries($request->all());
        return redirect('admin/geo')->with('message', 'Новые страны успешно добавлены');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $action = camel_case($id);
        if (method_exists($this, $action)) {
            return $this->$action($request);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = $this->model->getCountry($id);
        return view('admin.geo.edit_country', [
            'country' => $country
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->validateCountry($request);

        $this->model->updateCountry($id, $request->all());
        return redirect('admin/geo')->with('message', 'Country "' . $request->get('country') . '" has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCities($request)
    {

        if (!$request->ajax()) {
            return abort(404);
        }
        $city_model = new Cities();
        $cities = $city_model->where('country_id', $request->get('country_id'))->get();

        return view('admin.geo.cities', [
            'cities' => $cities
        ]);

    }


    public function deleteCity($id)
    {
        $city_model = new Cities();
        $city_model->where('id', $id)->delete();
        return back()
            ->with('message', 'City has been deleted');
    }


    public function showCity($id)
    {

        $city = Cities::find($id);
        return view('admin.geo.city_form', compact('city'));

    }


    public function updateCity(Request $request, $id)
    {

        $data = $request->all();
        unset($data['_token']);
        unset($data['files']);
        Cities::where('id', $id)->update($data);

        return redirect('admin/geo')
            ->with('message', 'Город "' . $request->get('city') . '" успешно обновлен');

    }

    public function setImage(Request $request)
    {

        $data = $request->all();
        $this->model->where('id', $data['id'])->update(['images' => json_encode($data['image'])]);
    }

    public function uploadFlag(Request $request)
    {

        $image = $request->file('file');
        $imgObj = Image::make($image);

        $imageName = time() . '.' . $image->getClientOriginalExtension();

        if ($imgObj->width() > 300) {

            $imgObj->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($imgObj->height() > 235) {

            $imgObj->resize(null, 235, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save(public_path('uploads/countries/flags') . '/' . $imageName, 75);

        return json_encode([
            'success' => 200,
            'filename' => $imageName
        ]);

    }

    public function uploadBanner(Request $request)
    {
        $image = $request->file('file');
        $imgObj = Image::make($image);

        $imageName = time() . '.' . $image->getClientOriginalExtension();

        if ($imgObj->width() > 1920) {

            $imgObj->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($imgObj->height() > 545) {

            $imgObj->resize(null, 235, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $imgObj->save(public_path('uploads/countries/banners') . '/' . $imageName, 100);

        return json_encode([
            'success' => 200,
            'filename' => $imageName
        ]);
    }

    public function setFlag(Request $request)
    {
        $data = $request->all();

        $unit = $this->model->find($data['id']);
        File::delete(public_path('uploads/countries/flags') . '/' . $unit->flag);

        if (!isset($data['image'])) {
            $unit = $this->model->find($data['id']);
            File::delete(public_path('uploads/countries/flags') . '/' . $unit->flag);

            return $this->model->where('id', $data['id'])->update(['flag' => json_encode("")]);
        } else {
            return $this->model->where('id', $data['id'])->update(['flag' => json_encode($data['image'])]);
        }
    }

    public function setBanner(Request $request)
    {
        $data = $request->all();

        $unit = $this->model->find($data['id']);
        File::delete(public_path('uploads/countries/banners') . '/' . $unit->flag);

        if (!isset($data['image'])) {
            $unit = $this->model->find($data['id']);
            File::delete(public_path('uploads/countries/banners') . '/' . $unit->flag);

            return $this->model->where('id', $data['id'])->update(['banner' => json_encode("")]);
        } else {
            return $this->model->where('id', $data['id'])->update(['banner' => json_encode($data['image'])]);
        }
    }

    public function removeImage(Request $request)
    {
        $data = $request->all();
        $this->model->where('id', $data['id'])->update(['images' => null]);
    }


    // Validations methods
    public function validateCountries($request)
    {
        $rules = [
            'countries' => 'required'
        ];
        return $this->validate($request, $rules, [], ['countries' => 'Страны']);
    }

    public function validateCountry($request)
    {
        $rules = [
            'country' => 'required',
            'slug' => 'required|unique:geo_countries'
        ];
        $fields = [
            'cities' => 'Города',

        ];
        return $this->validate($request, $rules, [], $fields);
    }

}