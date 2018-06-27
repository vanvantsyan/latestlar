<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class Points extends Base
{
    use Cachable;
    protected $table = 'points';

    protected $appends = ['count_tours'];
    
    protected $guarded = ['id'];
    
    protected $casts = [
        'title_cases' => 'array'
    ];

    public function geoRelationSub()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('sub_ess', 'point');
    }

    public function geoRelationPar()
    {
        return $this->hasMany('App\Models\GeoRelation', 'par_id')->where('par_ess', 'point');
    }


    public static function popular()
    {
        return self::where('popular', '=', 1)->get()->keyBy('id');
    }

    public static function goldens()
    {
        return self::with(['geoRelationSub' => function ($query) {
            $query->where('par_id', 319)->where('par_ess', 'way');
        }])->where('off', 0)
            ->where('popular', '1')
            ->get();
    }

    public function getCountToursAttribute()
    {
        return $this->geoRelationPar()->where('sub_ess','tour')->count();
    }

}
