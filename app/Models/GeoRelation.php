<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoRelation extends Model
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


}
