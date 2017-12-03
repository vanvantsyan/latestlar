<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'posts_categories';

    protected $fillable = ['title', 'description', 'private', 'slug'];

    public function scopePublished($query)
    {
        return $query->where('private', false);
    }

    public function articles()
    {
        return $this->hasMany(Blog::class, 'category_id', 'id');
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
