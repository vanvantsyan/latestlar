<?php

namespace App\Models;

class Cities extends Base
{

    protected $table = 'geo_cities';
    protected $fillable = ['country_id', 'city'];

    public $timestamps = false;



}
