<?php


namespace App\Repositories\Eloquent;


use App\Models\User;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements IUser
{

    public function model()
    {
        return User::class;
    }

}
