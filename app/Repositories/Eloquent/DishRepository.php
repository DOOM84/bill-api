<?php


namespace App\Repositories\Eloquent;


use App\Models\Dish;
use App\Repositories\Contracts\IDish;
use Illuminate\Http\Request;

class DishRepository extends BaseRepository implements IDish
{

    public function model()
    {
        return Dish::class;
    }

    public function applyImage($filename, $status/*, $hall*//*, $path*/)
    {
        $picture = $this->model->create([
            'path' => $filename,
            'status' => $status,
            //'disk' => config($path),
        ]);
        return $picture;
    }

}
