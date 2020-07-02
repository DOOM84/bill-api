<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PriceCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\PriceResource';


    public function toArray($request)
    {
        return [
            $this->collection,
        ];
    }
}
