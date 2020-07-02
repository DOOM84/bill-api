<?php


namespace App\Repositories\Eloquent;


use App\Models\Picture;
use App\Repositories\Contracts\IPicture;
use Illuminate\Http\Request;

class PictureRepository extends BaseRepository implements IPicture
{

    public function model()
    {
        return Picture::class;
    }

    public function applyImage($filename, $hall, $status/*, $path*/)
    {
        $picture = $this->model->create([
            'path' => $filename,
            'hall' => $hall,
            'status' => $status,
            //'disk' => config($path),
        ]);
        return $picture;
    }

}
