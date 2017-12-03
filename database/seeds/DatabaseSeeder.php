<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $user = User::firstOrNew(['email' => 'admin@admin']);
        $user->password = Hash::make('admin');
        $user->save();
        $role = Role::firstOrCreate(['name' => 'admin']);
        $permission = Permission::firstOrCreate(['name' => 'users']);
        $role->perms()->sync([
            $permission->id
        ]);
        if (!$user->hasRole('admin')) {
            $user->attachRole($role);
        }
    }
}
