<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\adminUserResource;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $users;

    public function __construct(IUser $users)
    {
        $this->users = $users;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'users' => adminUserResource::collection($this->users->all())
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ],
            [
                'name.required' => 'Пожалуйста, укажите имя пользователя',
                'name.unique' => 'Пользователь с таким именем уже существует',
                'name.max' => 'Имя пользователя не должно быть более 255 символов',
                'name.string' => 'Имя пользователя  должно быть текстом',
                'email.required' => 'Пожалуйста, укажите Email пользователя',
                'email.string' => 'Email пользователя  должен быть текстом',
                'email.email' => 'Email пользователя должен быть корректным адресом',
                'email.max' => 'Email пользователя не должен быть более 255 символов',
                'email.unique' => 'Пользователь с таким Email адресом уже существует',
                'password.required' => 'Пожалуйста, укажите пароль пользователя',
                'password.string' => 'Пароль пользователя  должен быть текстом',
                'password.min' => 'Пароль пользователя не должен быть менее 6 символов',
                'password.confirmed' => 'Введенные пароли не совпадают',
            ]);

        $request['status'] = !$request['status'] ? 0 : 1;
        $user = $this->users->create($request->all());

        return response(['success' => 'Администратор успешно добавлен',
            'user' => new adminUserResource($user),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:users,name,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'confirmed',
        ],
            [
                'name.required' => 'Пожалуйста, укажите имя пользователя',
                'name.max' => 'Имя пользователя не должно быть более 255 символов',
                'name.unique' => 'Пользователь с таким именем уже существует',
                'name.string' => 'Имя пользователя  должно быть текстом',
                'email.required' => 'Пожалуйста, укажите Email пользователя',
                'email.string' => 'Email пользователя  должен быть текстом',
                'email.email' => 'Email пользователя должен быть корректным адресом',
                'email.max' => 'Email пользователя не должен быть более 255 символов',
                'email.unique' => 'Пользователь с таким Email адресом уже существует',
                'password.confirmed' => 'Введенные пароли не совпадают',
            ]);

        $request['status'] = !$request['status'] ? 0 : 1;

        if (!$request->get('password')) {
            $user = $this->users->update($id, $request->except('password'));
        } else {
            $user = $this->users->update($id, $request->all());
        }
        return response(['success' => 'Администратор успешно изменен',
            'user' => new adminUserResource($user),
            ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$user = $this->users->find($id);

        $this->users->delete($id);

        return response(['success' => 'Администратор успешно удален'], Response::HTTP_ACCEPTED);
    }
}
