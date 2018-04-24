<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ways extends Model
{

    protected $table = 'ways';
    protected $guarded = [];

    protected $appends = ['count_tours'];

    public function relGeoSub()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('sub_id', 'way');
    }

    public function relGeoPar()
    {
        return $this->hasMany('App\Models\GeoRelation', 'par_id')->where('par_ess', 'way');
    }

    public function getMinPrice()
    {
//        return $this->join/
    }

    public function country(){
        return $this->hasOne('App\Models\Geo','magput','id');
    }

    public static function hotWays()
    {
        return self::join('geo_relation AS gr', function ($join) {
            $join->on('gr.par_id', '=', 'ways.id')
                ->where('gr.par_ess', '=', 'way')
                ->where('gr.sub_ess', '=', 'tour');
        })->join('tours', 'gr.sub_id', '=', 'tours.id')
            ->where('tours.price', '>', 0)
            ->where('ways.status', 'country')
            ->select('ways.*', DB::raw('min(tours.price) as minPrice'))
            ->groupBy('ways.id')
            ->take(6)
            ->get()
            ->keyBy('id');
    }

    public function getCountToursAttribute()
    {
        return $this->relGeoPar()->where('sub_ess','tour')->count();

    }


}
