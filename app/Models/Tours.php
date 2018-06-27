<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Tours extends Base
{

    protected $table = 'tours';
    protected $fillable = ['id', 'title', 'description', 'text', 'price', 'duration', 'source', 'url', 'created_at', 'updated_at', 'title_cases'];

    protected $appends = ['country']; //,'nearestDate'
//    protected $casts = ['nearestDate' => 'string'];
    protected $casts = [
        'title_cases' => 'array',
    ];

    public function tourTags()
    {
        return $this->hasMany('App\Models\ToursTagsRelation', 'tour_id');
    }

    public function dates()
    {
        return $this->hasMany('App\Models\ToursTagsRelation', 'tour_id')->where('tag_id', 2)->orderBy('value');
    }

    public function getCountryAttribute()
    {
        $rel = $this->tourGeoSub->where('par_ess', 'country')->first()->toArray('par_id');
        if($rel['par_id']) {
            return Geo::find($rel['par_id']);
        }
        return 0;
    }

    public function getNearestDateAttribute($value)
    {
        return $this->tourTags->where('tag_id', 2)->where('value','>',time())->sortBy('value')->first();
    }

    public function getTravelTypesAttribute($value)
    {
        return $this->tourTags->where('tag_id', 1);
    }

    public function tourGeoSub()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('sub_ess','tour');
    }

    public function parPoints()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('sub_ess','tour')->where('par_ess', 'point');
    }

    public function parWays()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('sub_ess','tour')->where('par_ess', 'way');
    }

    // Scopes
    public function scopeFromCountry($query, $country_slug)
    {
        if ($country_slug) {
            $query->leftJoin('geo_relation AS g_rel', function ($join) {
                $join->on('g_rel.sub_id', '=', 'tours.id')
                    ->where('sub_ess', '=', 'tour')
                    ->where('par_ess', '=', 'country');
            });
            $query->leftJoin('geo_countries AS countries', 'countries.id', '=', 'g_rel.par_id');
            $query->where('countries.slug', $country_slug);
        }

        return $query;
    }

    public function scopeWithType($tours, $tourType)
    {
        if ($tourType)
            $tours->leftJoin('tour_tags_relations AS ttrType', function ($query) {
                $query->on('ttrType.tour_id', '=', 'tours.id');
//                    ->where('ttrType.tag_id', '=', 4);
            })->where('ttrType.value', $tourType);

        return $tours;
    }

    public function scopeWithDates($tours, $toursIds)
    {
        $tours->leftJoin(
            DB::raw("
            (
            SELECT tour_id, MIN(value) as nearestDate
            
                FROM tour_tags_relations 
                
                WHERE tag_id = 2 
                AND value > " . time() . " 
                AND tour_id IN(" . implode(', ', $toursIds) . ")
            GROUP BY tour_id
            ) as dv
            ")
            ,
            'tours.id', '=', 'dv.tour_id'
        );

        return $tours;
    }

    /**
     * Получить туры с датами в заданном диапазоне.
     * 
     * @param $query
     * @param $dateFrom диапазон даты "от"
     * @param $dateTo диапазон даты "до"
     */
    public function scopeWithDatesInRange($query, $dateFrom, $dateTo)
    {
        $query->with(['dates' => function ($subquery) use ($dateFrom, $dateTo) {
            $subquery->where('value', '>=', $dateFrom ? $dateFrom : now()->getTimestamp())
                ->where('value', '<=', $dateTo ? $dateTo : (string) PHP_INT_MAX);
        }]);
    }

    public function scopeActualDate($tours)
    {
        $tours->leftJoin(
            DB::raw("
            (
            SELECT tour_id, MIN(value) as nearestDate
            
                FROM tour_tags_relations 
                
                WHERE tag_id = 2 
                AND value > " . time() . " 
            GROUP BY tour_id
            ) as dv
            ")
            ,
            'tours.id', '=', 'dv.tour_id'
        );

        return $tours;
    }

    public function scopePriceFrom($tours, $priceFrom)
    {
        if ($priceFrom) {
            return $tours->where('tours.price', '>=', $priceFrom);
        }
        return $tours;
    }

    public function scopePriceTo($tours, $priceTo)
    {
        if ($priceTo) {
            return $tours->where('tours.price', '<=', $priceTo);
        }
        return $tours;
    }

    public function scopeForDate($tours, $dateFrom, $dateTo)
    {
        /*
        $dateRelation = ToursTagsRelation::join('tours', 'tours.id', '=', 'tour_tags_relations.tour_id', 'right outer')
            ->where(function ($query) use ($dateFrom, $dateTo) {
                $query->where(function ($query) use ($dateFrom, $dateTo) {
                    $query->where('tour_tags_relations.value', '>=', strtotime($dateFrom))
                        ->where('tour_tags_relations.value', '<=', strtotime($dateTo));
                });//->orWhereNull('tour_tags_relations.value');
            })->pluck('tours.id')->toArray();

        //->pluck('tours.id','tour_tags_relations.value');
        //->groupBy('tours.id')->pluck('tours.id')->toArray();

        $tours->leftJoin('tour_tags_relations AS ttrDate', function ($query) use ($dateFrom, $dateTo, $dateRelation) {
            $query->on('ttrDate.tour_id', '=', 'tours.id')
                ->where('ttrDate.tag_id', '=', 2);
        })->whereIn('ttrDate.tour_id', array_unique($dateRelation));
        */
        
        $subquery = ToursTagsRelation::from('tour_tags_relations as ttr')->selectRaw('ttr.tour_id, min(ttr.value) as minDate')
            ->where('ttr.tag_id', 2)
            ->where('ttr.value', '>=', $dateFrom ? $dateFrom : now()->getTimestamp())
            ->where('ttr.value', '<=', $dateTo ? $dateTo : (string) PHP_INT_MAX)
            ->groupBy('ttr.tour_id');

        $tours->join(DB::raw("({$subquery->toSql()}) AS ttrDates"),
            function ($query) use ($subquery) {
                $query->on('ttrDates.tour_id', 'tours.id')
                    ->addBinding($subquery->getBindings());
            });

        return $tours;
//            $tours->addSelect('ttrDate.value','ttrDate.tour_id');
//            $tours->orderBy('ttrDate.value', "DESC");
    }

    public function scopeFromResort($tours, $resort)
    {
        if ($resort) {
            $tours->join('geo_relation AS geo_w', function ($query) use ($resort) {
                $query->on('geo_w.sub_id', '=', 'tours.id')
                    ->where('geo_w.sub_ess', 'tour')
                    ->where('geo_w.par_ess', substr(strtolower(class_basename($resort)), 0, -1));
            })->where('geo_w.par_id', $resort->id);
        }

        return $tours;
    }

    public function scopeFromWay($tours, $tourWay)
    {
        $way = Ways::where('title', $tourWay)->select('id')->first();
        
        if ($tourWay) {
            $tours->join('geo_relation AS geo_w', function ($query) use ($way) {
                $query->on('geo_w.sub_id', '=', 'tours.id')
                    ->where('geo_w.sub_ess', 'tour')
                    ->where('geo_w.par_ess', 'way');
            })->where('geo_w.par_id', $way->id ?? $tourWay);
        }

        return $tours;
    }

    public function scopeFromPoint($tours, $tourPoint)
    {
        $point = Points::where('title', $tourPoint)->select('id')->first();

        if ($tourPoint) {
            $tours->join('geo_relation AS geo_r', function ($query) use ($point) {
                $query->on('geo_r.sub_id', '=', 'tours.id')
                    ->where('geo_r.sub_ess', 'tour')
                    ->where('geo_r.par_ess', 'point');
            })->where('geo_r.par_id', $point->id ?? $tourPoint);
        }

        return $tours;
    }


}



