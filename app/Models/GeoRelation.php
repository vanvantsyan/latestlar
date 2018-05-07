<?php

namespace App\Models;

class GeoRelation extends Base
{

    protected $table = 'geo_relation';

    public function tours()
    {
        return $this->belongsTo('App\Models\Tours', 'sub_id', 'id')->min('price');
    }

    public function pointsPar()
    {
        return $this->belongsTo('App\Models\Points', 'par_id', 'id');
    }

    public function waysPar()
    {
        return $this->belongsTo('App\Models\Ways', 'par_id', 'id');
    }

    public function minPrice(){
        return $this->tours()->min('price');
    }

    public function countryPar(){
        return $this->belongsTo('App\Models\Geo','par_id','id');
    }


}
