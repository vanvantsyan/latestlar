<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ways extends Model
{

    protected $table = 'ways';
    protected $guarded = [];

    public function relGeoSub() {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('sub_id','way');
    }

    public function relGeoPar() {
        return $this->hasMany('App\Models\GeoRelation', 'par_id')->where('par_ess','way');
    }

    public function getMinPrice(){
//        return $this->join/
    }


}
