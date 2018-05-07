<?php

namespace App\Models;

class Worldparts extends Base
{

    protected $table = 'ways';
    protected $fillable = ['id', 'title', 'description', 'url','status','off','created_at','updated_at'];

}
