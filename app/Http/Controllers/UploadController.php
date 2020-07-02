<?php

namespace App\Http\Controllers;

use App\Jobs\UploadImage;
use App\Jobs\UploadMenu;
use App\Repositories\Contracts\IDish;
use App\Repositories\Contracts\IPicture;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    protected $pictures, $dishes;

    public function __construct(IPicture $pictures, IDish $dishes)
    {
        $this->pictures = $pictures;
        $this->dishes = $dishes;
    }

    /*public function uploadImg(Request $request)
    {
        //validate the request
        $this->validate($request, [
            //'image' => ['required', 'mimes:jpeg,gif,bmp,png', 'file', 'max:2048'],
            'hall' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);
       // var_dump(gettype($request->status));

        if($request->hasfile('images'))
        {
            foreach($request->file('images') as $image)
            {
                //$image_path = $image->getPathname();
                $filename = time() . "_" . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
                $tmp = $image->storeAs('uploads/Images/original', $filename, 'tmp');
                $picture = $this->pictures->applyImage($filename, $request->hall, $request->status ? true : false);
                $this->dispatch(new UploadImage($picture));
            }
        }
        return response()->json('uploaded', 200);

    }*/

    public function uploadMenu(Request $request)
    {
        //validate the request
        $this->validate($request, [
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if($request->hasfile('images'))
        {
            foreach($request->file('images') as $image)
            {
                //$image_path = $image->getPathname();
                $filename = time() . "_" . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
                $tmp = $image->storeAs('uploads/Dishes/original', $filename, 'tmp');
                $picture = $this->dishes->applyImage($filename);
                $this->dispatch(new UploadMenu($picture));
            }
        }
        return response()->json('uploaded', 200);

    }
}
