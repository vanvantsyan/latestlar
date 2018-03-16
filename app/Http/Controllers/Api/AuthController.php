<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\LoginRequest;
use Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        if (Auth::attempt([
            'email' => $request->login,
            'password' => $request->password,
        ])) {
            return response()->json([
                'ok' => true,
                'route' => route('front.index')
            ]);
        }

        return response()->json([
            'ok' => false,
            'errors' => [
                'login' => 'Неправильный логин или пароль'
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'ok' => true,
            'route' => route('front.index')
        ]);
    }
}
