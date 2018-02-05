<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursTags extends Model
{
    protected $table = 'tours_tags';

    public function relationTours(){
        return $this->hasMany('App\Models\ToursTagsRelation', 'tag_id');
    }

}
