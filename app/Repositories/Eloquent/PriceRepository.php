<?php
namespace App\Repositories\Eloquent;

use App\Models\Price;
use App\Repositories\Contracts\IPrice;

class PriceRepository extends BaseRepository implements IPrice
{
    public function model()
    {
        return Price::class;
    }

}
