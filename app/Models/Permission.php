<?php namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    // количество item'ов на странице
    const perpage = 15;

    public function getPermissions($is_paginate = false) {
        return $is_paginate
            ? $this->paginate(self::perpage)
            : $this->all();
    }

    public function getPermission($id) {
        return $this->findOrFail($id);
    }

    public function savePermission($data) {
        Permission::create($data);
    }

    public function updatePermission($data, $id) {
        $permission = $this->findOrFail($id);
        $permission->update($data);
    }

    public function deletePermission($id) {
        $permission = Permission::findOrFail($id);
        $permission->delete();
    }

}
