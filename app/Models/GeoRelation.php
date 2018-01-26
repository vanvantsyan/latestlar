<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoRelation extends Model
{

    protected $table = 'geo_relation';

    public function toursPoints()
    {
        return $this->belongsTo('App\Models\Tours', 'id', 'sub_id');
    }

    public function pointsPar()
    {
        return $this->belongsTo('App\Models\Points', 'par_id', 'id');
    }

    public function waysPar()
    {
        return $this->belongsTo('App\Models\Ways', 'par_id', 'id');
    }

    public function getPointAttribute($value)
    {
        return $this->pointsPar; //TODO
    }

    public function getCityCountAttribute($type)
    {
        return $this->pointsPar()->where('status', 'city');
    }
}
