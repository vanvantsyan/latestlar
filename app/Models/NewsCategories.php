<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategories extends Base
{

    protected $table = 'news_categories';
    protected $fillable = ['parent_id', 'title', 'description', 'image', 'seo_title', 'seo_h1', 'seo_desc', 'seo_keywords', 'slug'];
    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function news()
    {
        return $this->hasMany(News::class, 'category_id', 'id');
    }
}
