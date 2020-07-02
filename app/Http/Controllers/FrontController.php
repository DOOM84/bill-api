<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use App\Http\Resources\DishResource;
use App\Http\Resources\InfoResource;
use App\Http\Resources\PictureResource;
use App\Http\Resources\PriceResource;
use App\Http\Resources\ReviewResource;
use App\Repositories\Contracts\IContact;
use App\Repositories\Contracts\IDish;
use App\Repositories\Contracts\IInfo;
use App\Repositories\Contracts\IPicture;
use App\Repositories\Contracts\IPrice;
use App\Repositories\Contracts\IReview;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    protected $prices;
    protected $info;
    protected $pictures;
    protected $reviews;
    protected $dishes;
    protected $contacts;

    public function __construct(IPrice $prices, IInfo $info, IPicture $pictures,
                                IReview $reviews, IDish $dishes, IContact $contacts)
    {
        $this->prices = $prices;
        $this->info = $info;
        $this->pictures = $pictures;
        $this->reviews = $reviews;
        $this->dishes = $dishes;
        $this->contacts = $contacts;

    }

    public function index()
    {
        $info = new InfoResource($this->info->findFirst());
        $pictures = PictureResource::collection($this->pictures->findWhere('status', 1));
        $reviews = ReviewResource::collection($this->reviews->all());
        $prices = PriceResource::collection($this->prices->orderAll('id', 'asc'))
            ->collection->groupBy('hall');

        //return new PriceGroupCollection($prices);

        return response()->json([
            'info' => $info,
            'prices' => $prices,
            'pictures' => $pictures,
            'reviews' => $reviews,
        ]);
    }

    public function menu()
    {
        return response()->json([
            'dishes' => DishResource::collection($this->dishes->findWhere('status', 1))
        ]);
    }

    public function contacts()
    {
        return response()->json([
            'contacts' => new ContactResource($this->contacts->findFirst())
        ]);
    }
}
