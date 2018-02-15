<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticlesCategories extends Model
{

    protected $table = 'articles_categories';
    protected $guarded = [];
    public $timestamps = false;

    public function news()
    {
        return $this->hasMany(Articles::class, 'category_id', 'id');
    }

}
