<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{

    protected $table = 'visa';
    protected $fillable = ['country_id', 'time', 'amount', 'amount_desc', 'docs', 'add_docs', 'seo_h1', 'seo_title', 'seo_desc', 'seo_keywords', 'slug'];


    public function countries(){

        return $this->hasOne(Geo::class, 'id','country_id');

    }

}
