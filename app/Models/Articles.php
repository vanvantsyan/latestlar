<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{

    protected $table = 'articles';
    protected $guarded = [];
    public $timestamps;

    public function categories(){

        return $this->hasOne('App\Models\ArticlesCategories', 'id', 'category_id');

    }

}
