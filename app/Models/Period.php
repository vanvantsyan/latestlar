<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Period extends Model
{
    //
    protected $table = 'periods';
    
    protected $guarded = [];
    
    protected $casts = [
        'date_from' => 'date',
        'date_to'   => 'date',
        'title_cases' => 'array',
    ];
}
