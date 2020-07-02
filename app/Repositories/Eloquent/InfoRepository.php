<?php
namespace App\Repositories\Eloquent;

use App\Models\Info;
use App\Repositories\Contracts\IInfo;

class InfoRepository extends BaseRepository implements IInfo
{
    public function model()
    {
        return Info::class;
    }


}
