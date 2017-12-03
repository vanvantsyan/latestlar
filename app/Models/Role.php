<?php namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    protected $table = 'roles';
    protected $fillable = ['name', 'display_name', 'description'];

    public $timestamps;

// количество item'ов на странице
    const perpage = 15;

    public function getRoles($is_paginate = false) {
        return $is_paginate
            ? $this->paginate(self::perpage)
            : $this->all();
    }

    public function getRole($id) {
        return $this->findOrFail($id);
    }

    public function getRoleByName($value, $name = 'name') {
        return $this->where($name, $value)->first();
    }

    public function saveRole($data) {
        return Role::create($data);
    }

    public function updateRole($data, $id) {
        $role = $this->findOrFail($id);
        $role->update($data);
    }

    public function deleteRole($id) {
        $role = Role::findOrFail($id);
        $role->delete();
    }


}
