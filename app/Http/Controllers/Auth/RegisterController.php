<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\PrivateUserResource;
use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function action(RegisterRequest $request)
    {
        $user = User::create($request->all());
        return new PrivateUserResource($user->fresh());
    }
}
