<?php

namespace App;

use App\Mail\NewUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPas;
use App\Notifications\ResetPassword;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const perpage = 15;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function getUsers() {
        return $this->paginate(self::perpage);
    }

    public function getUser($id) {
        return $this->findOrFail($id);
    }

    public function updateUser($data, $id) {
        $user = $this->findOrFail($id);
        if(!empty($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $user->update($data);
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function saveUser($data) {
        $passw = mt_rand(100000, 999999);
        $data['password'] = bcrypt($passw);

        $user = User::create($data);

        \Mail::to($user)->send(new NewUser($data, $passw));

        return $user;
    }


    public static function getUsersForType($type_name){

        return DB::table('roles')
                ->where('roles.name', $type_name)
                ->leftJoin('role_user', 'roles.id', '=', 'role_user.role_id')
                ->leftJoin('users', 'role_user.user_id', '=', 'users.id')
                ->select('users.*')
                ->orderBy('name', 'ASC')
                ->get();

    }



}
