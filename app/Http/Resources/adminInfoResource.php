<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class adminInfoResource extends JsonResource
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
            'general' => $this->general,
            'rus' => $this->rus,
            'pool' => $this->pool,
            'halls' => $this->halls,
            'other' => $this->other,
        ];
    }
}
