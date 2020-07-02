<?php
namespace App\Repositories\Eloquent;

use App\Models\Review;
use App\Repositories\Contracts\IReview;

class ReviewRepository extends BaseRepository implements IReview
{
    public function model()
    {
        return Review::class;
    }



}
