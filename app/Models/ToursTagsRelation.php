<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursTagsRelation extends Model
{
    protected $table = 'tour_tags_relations';

    public function tours()
    {
        return $this->belongsTo('App\Models\Tours', 'id','tour_id');
    }

    public function tag() {
        return $this->belongsTo('App\Models\ToursTags', 'tag_id');
    }
}
