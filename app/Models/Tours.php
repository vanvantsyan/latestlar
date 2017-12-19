<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tours extends Model
{

    protected $table = 'tours';
    protected $fillable = ['id', 'title', 'description', 'text','price','duration','source','url','created_at','updated_at'];

}
