<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reviews extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['user_name', 'text', 'moderation', 'created_at'];

    public function scopePublished($query)
    {
        return $query
            ->where('created_at', '<=', Carbon::now()->endOfDay())
            ->where('moderation', true);
    }
}
