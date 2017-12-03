<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    protected $table = 'controllers';
    protected $fillable = ['name', 'title', 'options'];

    public $timestamps = false;


    public function insertSettings($data, $name, $title){

        unset($data['_token']);
        unset($data['_settings']);

        $arr['options'] = json_encode($data);
        $arr['name'] = $name;
        $arr['title'] = $title;

        return $this->firstOrCreate($arr);

    }


    public function updateSettings($data, $name, $title){

        unset($data['_token']);
        unset($data['_settings']);
        unset($data['_method']);

        $arr['options'] = json_encode($data);
        $arr['name'] = $name;
        $arr['title'] = $title;

        return $this->where('name', $name)->update($arr);

    }

}
