<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{

    protected $table = 'geo_cities';
    protected $fillable = ['country_id', 'city'];

    public $timestamps = false;



}
