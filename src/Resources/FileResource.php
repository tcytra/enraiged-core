<?php

namespace Enraiged\Files\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /** @var  string|null  The "data" wrapper that should be applied.*/
    public static $wrap;

    /**
     *  Transform the resource collection into an array.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @return array
     */
    public function toArray($request): array
    {
        return [
            'mime' => $this->mime,
            'name' => $this->name,
            'size' => $this->size,
            'type' => $this->type,
        ];
    }
}
