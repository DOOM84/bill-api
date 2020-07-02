<?php

namespace App\Jobs;

use App\Models\Review;
use Illuminate\Support\Facades\Storage;
use Image;
use File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadAvatar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $disk = 'public'; //$this->design->disk;
        $filename =  $this->review->avatar;
        $original_file = storage_path() . '/uploads/Avatars/original/' . $filename;

        try {
            //create the large Img and save to tmp disk
            Image::make($original_file)/*->fit(800, 600, function ($constraint){
                $constraint->aspectRatio();
            })*/->save($large = storage_path('uploads/Avatars/original/'. $filename));


            //create the thumbnail  Img and save to tmp disk
            Image::make($original_file)->resize(120, 120, function ($constraint){
                $constraint->aspectRatio();
            })->save($thumbnail = storage_path('uploads/Avatars/thumbnail/'. $filename));

            //store image to permanent disk
            //original image
            if(Storage::disk($disk)
                ->put('uploads/Avatars/original/'. $filename, fopen($original_file, 'r+'))){
                File::delete($original_file);
            }

            //thumbnail image
            if(Storage::disk($disk)
                ->put('uploads/Avatars/thumbnail/'. $filename, fopen($thumbnail, 'r+'))){
                File::delete($thumbnail);
            }

        }catch (\Exception $e){
            \Log::error($e->getMessage());

        }
    }
}
