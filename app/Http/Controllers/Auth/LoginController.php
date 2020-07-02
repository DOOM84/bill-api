<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\PrivateUserResource;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function action(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'email' => ['Неверные учетные данные']
                ]
            ], 422);

        }

        if(!$request->user()->status){
            auth()->logout();
            return response()->json([
                'errors' => [
                    'email' => ['Ваша учетная запись заблокирована']
                ]
            ], 403);
        }

        return (new PrivateUserResource($request->user()))->additional([
            'meta' => [
                'token' => $token
            ]
        ]);
    }
}
