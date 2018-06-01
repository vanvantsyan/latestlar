<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ToursSletat extends Base
{

    protected $table = 'tours_sletat';
    protected $fillable = ['id','price_id' ,'cityFrom_id','way_id','leaveDate','departDate','resort_id','hotel_id','operator_id',
        'hash_operator_id','adults_count','children_count','meal_type','hotel_category','hotel_desc','title', 'price', 'duration', 'source', 'image_url', 'finish_date' ,'tour_id_cash', 'created_at', 'updated_at'];


}



