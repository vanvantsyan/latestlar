<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = ['title', 'description', 'content', 'seo_title', 'seo_h1', 'seo_desc', 'seo_keywords', 'date_pub', 'slug', 'active_from'];

    protected $dates = ['active_from'];

    public function scopePublished($query)
    {
        return $query
            ->where('active_from', '<=', Carbon::now()->endOfDay());
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
