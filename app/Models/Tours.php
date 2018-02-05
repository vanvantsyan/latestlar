<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tours extends Model
{

    protected $table = 'tours';
    protected $fillable = ['id', 'title', 'description', 'text', 'price', 'duration', 'source', 'url', 'created_at', 'updated_at'];

    protected $appends = ['dates'];

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

    public function parPoints()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('par_ess','point');
    }

    public function parWays()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('par_ess','way');
    }


}



