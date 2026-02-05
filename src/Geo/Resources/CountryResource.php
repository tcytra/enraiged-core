<?php

namespace Enraiged\Geo\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     *  Transform the resource collection into an array.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @return array
     */
    public function toArray($request): array
    {
        $resource = [
            'id' => $this->id,
            'capital' => $this->capital,
            'citizenship' => $this->citizenship,
            'code' => $this->code,
            'long' => $this->long,
            'name' => $this->name,
            'is_active' => $this->is_active,
        ];

        return $resource;
    }
}
