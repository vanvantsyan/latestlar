<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToursTagsValues extends Model
{
    protected $table = 'tours_tags_values';

    protected $guarded = [];

    public function tag() {
        return $this->belongsTo('App\Models\ToursTags', 'tag_id');
    }

}
