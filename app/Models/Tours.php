<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Tours extends Model
{

    protected $table = 'tours';
    protected $fillable = ['id', 'title', 'description', 'text', 'price', 'duration', 'source', 'url', 'created_at', 'updated_at'];

    public function tourTags()
    {
        return $this->hasMany('App\Models\ToursTagsRelation', 'tour_id');
    }

    public function getDatesAttribute($value)
    {
        return $this->tourTags->where('tag_id', 2);
    }

    public function getTravelTypesAttribute($value)
    {
        return $this->tourTags->where('tag_id', 1);
    }

    public function tourGeoSub()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id');
    }

    public function getPointsAttribute()
    {
        return $this->tourGeoSub->where('sub_ess', 'tour')->where('par_ess', '=', 'point');
    }

    public function getWaysAttribute()
    {
        return $this->tourGeoSub->where('sub_ess', 'tour')->where('par_ess', '=', 'way');
    }

    public function getCityCountAttribute()
    {
        return $this
            ->join(DB::raw('geo_relation g'), 'tours.id', '=', 'sub_id')
            ->join(DB::raw('points p'), 'p.id', '=', 'g.par_id')
            ->where('g.sub_ess', 'tour')
            ->where('par_ess', 'point')
            ->where('p.status','city')
            ->where('tours.id',$this->id)
            ->count();
    }

}



