<?php

namespace App\Models;

class News extends Base
{

    protected $table = 'news';
    protected $fillable = ['category_id', 'title', 'description', 'content', 'image', 'author', 'seo_title', 'seo_h1', 'seo_desc', 'seo_keywords', 'slug', 'created_at'];
    public $timestamps;


    public function categories(){

        return $this->hasOne('App\Models\NewsCategories', 'id', 'category_id');

    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
