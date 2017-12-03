<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model
{

    protected $table = 'menu';
    protected $fillable = ['name', 'title'];

    public $timestamps = false;


    public function saveMenu($data){

        $this->name = $data['name'];
        $this->title = $data['title'];

        return $this->save();

    }


    public function getMenu($id){

        $menu = DB::table('menu')->where('id', $id)->first();
        $menu->items = DB::table('menu_items')->where('menu_id', $id)->get()->toArray();
        return $menu;

    }


    public function saveItem($data){

        unset($data['_token']);
        $data['out'] = $data['out'] == 'on' ? 1 : 0;
        $data['sort'] = 0;

        return DB::table('menu_items')->insert($data);

    }

    public function getMenuItem($id){

        $item = DB::table('menu_items')->where('id', $id)->first();
        $menu = DB::table('menu')->where('id', $item->menu_id)->first();
        $menu->item = $item;
        return $menu;

    }


    public function updateItem($data){

        unset($data['_token']);
        $data['out'] = $data['out'] == 'on' ? 1 : 0;

        return DB::table('menu_items')->where('id', $data['id'])->update($data);

    }


    public function deleteItem($data){

        return DB::table('menu_items')->where('id', $data['del_id'])->delete();

    }


}
