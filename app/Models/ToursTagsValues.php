<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursTagsValues extends Model
{
    protected $table = 'tours_tags_values';

    protected $guarded = [];

    protected $appends = ['count_tours'];

    public function tag()
    {
        return $this->belongsTo('App\Models\ToursTags', 'tag_id');
    }

    public function tourRelation()
    {
        return $this->hasMany('App\Models\ToursTagsRelation', 'value')->whereIn('tag_id', [3, 4, 5]);
    }

    public function getCountToursAttribute()
    {
//        $ids = Tours::actualDate()->pluck('id')->toArray();
//
//        return $this->tourRelation()->whereIn('tour_id', array_unique($ids))->count('id');
    }

}
