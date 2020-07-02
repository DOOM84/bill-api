<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PriceGroupCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\PriceCollection';

    public function toArray($request)
    {
        return [
            'entries' => $this->collection
        ];
    }
}
