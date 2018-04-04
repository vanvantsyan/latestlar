<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tours extends Model
{

    protected $table = 'tours';
    protected $fillable = ['id', 'title', 'description', 'text', 'price', 'duration', 'source', 'url', 'created_at', 'updated_at'];

    protected $appends = ['dates']; //,'nearestDate'
//    protected $casts = ['nearestDate' => 'string'];

    public function tourTags()
    {
        return $this->hasMany('App\Models\ToursTagsRelation', 'tour_id');
    }

    public function getDatesAttribute($value)
    {
        return $this->tourTags->where('tag_id', 2)->sortBy('value');
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
        return $this->hasMany('App\Models\GeoRelation', 'sub_id');
    }

    public function parPoints()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('par_ess', 'point');
    }

    public function parWays()
    {
        return $this->hasMany('App\Models\GeoRelation', 'sub_id')->where('par_ess', 'way');
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
        })->whereIn('ttrDate.tour_id', $dateRelation);

        return $tours;
//            $tours->addSelect('ttrDate.value','ttrDate.tour_id');
//            $tours->orderBy('ttrDate.value', "DESC");
    }

    public function scopeFromResort($tours, $resort)
    {

        if ($resort) {
            $tours->leftJoin('geo_relation AS geo_w', function ($query) use ($resort) {
                $query->on('geo_w.sub_id', '=', 'tours.id')
                    ->where('geo_w.sub_ess', 'tour')
                    ->where('geo_w.par_ess', substr(strtolower(class_basename($resort)), 0, -1));
            })->where('geo_w.par_id', $resort->id);
        }

        return $tours;
    }

    public function scopeFromWay($tours, $tourWay)
    {
        if ($tourWay) {
            $way = Ways::where('title', $tourWay)->select('id')->first();

            $tours->leftJoin('geo_relation AS geo_w', function ($query) {
                $query->on('geo_w.sub_id', '=', 'tours.id')
                    ->where('geo_w.sub_ess', 'tour')
                    ->where('geo_w.par_ess', 'way');
            })->where('geo_w.par_id', $way->id);
        }

        return $tours;
    }

    public function scopeFromPoint($tours, $tourPoint)
    {
        if ($tourPoint) {
            $point = Points::where('title', $tourPoint)->select('id')->first();

            $tours->leftJoin('geo_relation AS geo_r', function ($query) {
                $query->on('geo_r.sub_id', '=', 'tours.id')
                    ->where('geo_r.sub_ess', 'tour')
                    ->where('geo_r.par_ess', 'point');
            })->where('geo_r.par_id', $point->id);
        }

        return $tours;
    }


}



