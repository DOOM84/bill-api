<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\adminPictureResource;
use App\Jobs\UploadImage;
use App\Repositories\Contracts\IPicture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
    protected $pictures;

    public function __construct(IPicture $pictures)
    {
        $this->pictures = $pictures;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        return response()->json([
            'pictures' => adminPictureResource::collection($this->pictures->all())
        ], 200);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            //'image' => ['required', 'mimes:jpeg,gif,bmp,png', 'file', 'max:2048'],
            'hall' => 'required',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);

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

        return response()->json([
            'success' => 'Изображения успешно добавлены',
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $picture = $this->pictures->update($id, [
            'hall' => $request->hall,
            'status' => $request->status ? true : false,
        ]);

        return response()->json([
            'success' => 'Изображение успешно изменено',
            'picture' => new adminPictureResource($picture),
        ], Response::HTTP_ACCEPTED);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */


    public function destroy($id)
    {
        $picture = $this->pictures->find($id);

        foreach (['thumbnail', 'original'] as $size) {
            //check if file exists
            if (Storage::disk('public')->exists("/uploads/Images/{$size}/".$picture->path)){
                Storage::disk('public')->delete("/uploads/Images/{$size}/".$picture->path);
            }
        }

        $this->pictures->delete($picture->id);

        return response()->json(['success' => 'Изображение успешно удалено'], Response::HTTP_ACCEPTED);
    }
}
