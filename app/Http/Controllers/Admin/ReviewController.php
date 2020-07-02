<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\adminReviewResource;
use App\Jobs\UploadAvatar;
use App\Repositories\Contracts\IReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    protected $reviews;

    public function __construct(IReview $reviews)
    {
        $this->reviews = $reviews;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'reviews' => adminReviewResource::collection($this->reviews->all())
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'prof' => 'required',
            'message' => 'required',
        ]);

        if($request->hasfile('image'))
        {
            $image = $request->file('image');
                $filename = time() . "_" . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
                $tmp = $image->storeAs('uploads/Avatars/original', $filename, 'tmp');
        }
                $review = $this->reviews->create([
                    'name' => $request->name,
                    'prof' => $request->prof,
                    'message' => $request->message,
                    'avatar' => $filename,
                ]);
                $this->dispatch(new UploadAvatar($review));


        return response()->json([
            'success' => 'Отзыв успешно добавлен',
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
        $this->validate($request, [
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'prof' => 'required',
            'message' => 'required',
        ]);

        $filename = '';
        $review = $this->reviews->find($id);
        if($request->hasfile('image'))
        {
            foreach (['thumbnail', 'original'] as $size) {
                //check if file exists
                if (Storage::disk('public')->exists("/uploads/Avatars/{$size}/".$review->avatar)){
                    Storage::disk('public')->delete("/uploads/Avatars/{$size}/".$review->avatar);
                }
            }
            $image = $request->file('image');
            $filename = time() . "_" . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
            $tmp = $image->storeAs('uploads/Avatars/original', $filename, 'tmp');
        }

        $picture = $this->reviews->update($id, [
            'name' => $request->name,
            'prof' => $request->prof,
            'message' => $request->message,
            'avatar' => $filename ? $filename : $review->avatar,
        ]);

        if($request->hasfile('image')){
            $this->dispatch(new UploadAvatar($picture));
        }

        return response()->json([
            'success' => 'Отзыв успешно изменен',
            'review' => new adminReviewResource($picture),
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
        $review = $this->reviews->find($id);

        foreach (['thumbnail', 'original'] as $size) {
            //check if file exists
            if (Storage::disk('public')->exists("/uploads/Avatars/{$size}/".$review->avatar)){
                Storage::disk('public')->delete("/uploads/Avatars/{$size}/".$review->avatar);
            }
        }

        $this->reviews->delete($review->id);

        return response()->json(['success' => 'Отзыв успешно удален'], Response::HTTP_ACCEPTED);
    }
}
