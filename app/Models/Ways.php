<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ways extends Model
{

    protected $table = 'ways';
    protected $fillable = ['id', 'title', 'description', 'url','status','off','created_at','updated_at'];

}
