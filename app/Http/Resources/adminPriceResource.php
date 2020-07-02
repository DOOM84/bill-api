<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class adminPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'term' => $this->term,
            'rus' => $this->rus,
            'pool' => $this->pool,
            'hall' => $this->hall
        ];
    }
}
