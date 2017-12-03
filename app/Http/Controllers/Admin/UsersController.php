<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cities;
use App\Models\Geo;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UsersController extends Controller
{

    // модель пользователей
    private $model;
    private $role;

    public function __construct(){
        $this->model = new \App\User();
        $this->role  = new \App\Models\Role();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->model->getUsers();

        return view('admin.users.users_list', [
            'users' => json_encode($users)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can(['users'])){
            return abort(404);
        }
        $geo = new Geo();
        $countries = $geo->get();
        return view('admin.users.form_user', [
            'roles' => $this->role->getRoles(),
            'countries' => $countries,
            'cities' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = $request->get('roles', []);
        $user  = $this->model->saveUser($request->all());

        $user->attachRoles($roles);

        return redirect('admin/users')->with('message', 'User "'.$request->get('name').'" has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $action = camel_case($id);

        if(method_exists($this, $action)){
            return $this->$action($request);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can(['users'])){
            return abort(404);
        }
        $user = $this->model->getUser($id);
        $user_roles     = $user->roles()->get()->toArray();
        $user_roles_ids = array_column($user_roles, 'id');
        $geo = new Geo();
        $countries = $geo->get();
        $city_model = new Cities();
        $cities = $city_model->where('country_id', $user->country_id)->get();

        return view('admin.users.form_user', [
            'user'  => $user,
            'roles' => $this->role->getRoles(),
            'user_roles_ids' => $user_roles_ids,
            'countries' => $countries,
            'cities' => $cities
        ]);
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
        $this->model->updateUser($request->all(), $id);

        $roles = $request->get('roles', []);
        $user  = $this->model->getUser($id);
        $user->detachRoles();
        $user->attachRoles($roles);

        return redirect('admin/users')->with('message', 'User "'.$request->get('name').'" has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can(['crm_users_delete', 'crm_users_full'])){
            return abort(404);
        }
        $this->model->deleteUser($id);

        return redirect('admin/users');
    }


    public function reports(){

        if(!Auth::user()->can('reports')){
            return abort(404);
        }

    }


    public function delete($request){

        User::where('id', $request->get('id'))->delete();
        return redirect('admin/users')
                ->with('message', 'Пользователь успешно удален');

    }


}
