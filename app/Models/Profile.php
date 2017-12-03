<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Profile extends Model
{


    //TODO Оптимизировать JOINы!!!!
    public function getHotels($uid){

        $hotels = DB::table('hotels')
                ->where('hotels.user_id', $uid)
                ->leftJoin('geo_countries', 'hotels.country_id', '=', 'geo_countries.id')
                ->leftJoin('geo_cities', 'hotels.city_id', '=', 'geo_cities.id')
                ->select('geo_countries.country', 'geo_cities.city as city', 'hotels.*')
                ->get()->keyBy('id');

        $hids = $hotels->pluck('id');

        $hotels = collect($hotels)->toArray();

        foreach($hids as $hid){
            $hotels[$hid]->stats = DB::table('surveys_stats')->where('hotel_id', $hid)->where('moderation', 1)->select('stat')->get();
        }

        return $hotels;

    }


    public function getEntry($id){

        return DB::table('surveys_stats')
                ->where('surveys_stats.id', $id)
                ->leftJoin('hotels', 'surveys_stats.hotel_id', '=', 'hotels.id')
                ->select('hotels.name', 'surveys_stats.*')
                ->first();

    }


    public function getEntryQuestions($data){

        $qids = collect($data)->keys();

        return DB::table('issues')->whereIn('id', $qids)->get()->keyBy('id');

    }

}
