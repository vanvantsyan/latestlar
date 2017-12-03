<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{

    protected $table = 'questions';
    protected $fillable = ['question', 'answer', 'name', 'phone', 'email', 'created_at'];

    public $timestamps = false;

}
