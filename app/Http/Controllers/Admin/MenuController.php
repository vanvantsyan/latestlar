<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\MenuFacade as Menu;
use Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $new = [];
        $menus = Menu::all();

        foreach($menus as $menu){
            $m["ID"] = $menu->id;
            $m["SysName"] = $menu->name;
            $m["Title"] = $menu->title;
            $new[] = $m;
        }

        return view('admin.menu.index', [
            'menus' => json_encode($new)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Menu::saveMenu($request->all());
        return redirect('admin/menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(!is_numeric($id)){
            $action = camel_case($id);
            if(method_exists($this, $action)){
                return $this->$action($request);
            }
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function item($request)
    {
        $menu = Menu::getMenu($request->get('id'));
        return view('admin.menu.items', [
            'menu' => $menu
        ]);
    }


    public function addItem($request)
    {
        $menu = Menu::getMenu($request->get('id'));
        return view('admin.menu.add_item', [
            'menu' => $menu
        ]);
    }


    public function saveItem(Request $request)
    {
        $this->validateItem($request);

        Menu::saveItem($request->all());
        return redirect('admin/menu/item?id='.$request->get('menu_id'))
                    ->with('message', 'Пункт меню успешно создан');
    }


    public function itemEdit($request)
    {
        $menu = Menu::getMenuItem($request->get('id'));
        return view('admin.menu.add_item', [
            'menu' => $menu
        ]);
    }


    public function updateItem(Request $request)
    {
        $this->validateItem($request);
        Menu::updateItem($request->all());
        return redirect('admin/menu/item?id='.$request->get('menu_id'))
            ->with('message', 'Пункт меню успешно обновлен');
    }


    public function deleteItem(Request $request)
    {
        Menu::deleteItem($request->all());
        return redirect('admin/menu/item?id='.$request->get('menu_id'))
            ->with('message', 'Пункт меню успешно удален');
    }


    public function validateItem($request){

        if($request->get('out') == 'on'){
            $rxp = '';
        }else{
            $rxp = 'url';
        }
        $update = '';
        if($request->get('id')){
            $update = ',slug,'.$request->get('id');
        }

        return Validator::make($request->all(),[
            'slug' => 'required|unique:menu_items'.$update.'|'.$rxp,
            'title' => 'required'
        ])->validate();

    }


}
