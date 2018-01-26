<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{

    protected $table = 'points';

    public function geoRelationSub(){
        return $this->hasMany('App\Models\GeoRelation', 'sub_id');
    }

    public function geoRelationPar(){
        return $this->hasMany('App\Models\GeoRelation', 'par_id');
    }




}
