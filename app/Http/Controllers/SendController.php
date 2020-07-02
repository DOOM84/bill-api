<?php

namespace App\Http\Controllers;


use App\Http\Requests\ResetPassRequest;
use App\Mail\SendPass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendController extends Controller
{

    public function getPass(ResetPassRequest $request)
    {
        $pass = Str::random(10);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = $pass;
            $user->save();
            Mail::send(new SendPass($pass));
            return response()->json(['success' => 'Новый пароль успешно отправлен на Ваш E-mail адрес'], 200);
        }
        return response()->json(['errors' => ['email' => ['Такого E-mail адреса не существует']]], 422);
    }
}
