<?php

namespace App\Models;

use DB;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Geo extends Base
{
    use Cachable;

    protected $table = 'geo_countries';
    protected $fillable = ['country', 'description', 'slug', 'country_cases'];

    public $timestamps = false;

    protected $casts = [
        'flag' => 'array',
        'banner' => 'array',
        'country_cases' => 'array',
    ];

    protected $appends = ['count_tours'];

    public function saveCountries($data){

        $countries = preg_split("/\\r\\n|\\r|\\n/", $data['countries']);

        foreach($countries as $country){
            //$this->country = $country;
            $this->firstOrCreate([
                'country' => $country
            ]);
        }

    }


    public function getCountry($id){

        $city_model = new Cities();

        $country = $this->find($id);
        $country->cities = $city_model->where('country_id', $id)->get()->toArray();

        return $country;

    }


    public function updateCountry($id, $data){

        $country = $data;
        unset($country['files']);
        unset($country['_method']);
        unset($country['_token']);
        unset($country['cities']);
        Geo::find($id)->update($country);

        if(isset($data['cities'])) {
            $cities = preg_split("/\\r\\n|\\r|\\n/", $data['cities']);

            if(isset($data['old_cities'])){
                $old_cities = preg_split("/\\r\\n|\\r|\\n/", $data['old_cities']);
                $diff = array_diff($old_cities, $cities);
                if(!empty($diff)){
                    $this->deleteCity($diff, $id);
                }
            }

            foreach($cities as $city){
                if(!empty($city)) {
                    $this->saveCity($city, $id);
                }
            }
        }
    }


    public function saveCity($city, $country_id){

        $city_model = new Cities();

        return $city_model->firstOrCreate([
            'country_id' => $country_id,
            'city' => $city
        ]);

    }


    public function deleteCity($data, $id){

        foreach($data as $city){
            $city_model = new Cities();
            $city_model->where('city', $city)->where('country_id', $id)->delete();
        }

        return true;

    }

    public function relGeoSub()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('sub_id', 'country');
    }

    public function relGeoPar()
    {
        return $this->hasMany('App\Models\GeoRelation', 'par_id')->where('par_ess', 'country');
    }

    public function getCountToursAttribute()
    {
         return $this->relGeoPar()->where('sub_ess','tour')->count();

    }
}
