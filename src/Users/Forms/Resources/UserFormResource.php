<?php

namespace Enraiged\Users\Forms\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFormResource extends JsonResource
{
    /** @var  string|null  The "data" wrapper that should be applied.*/
    public static $wrap;

    /**
     *  Transform the resource into an array.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'alias' => $this->profile->alias,
            'email' => $this->email,
            'locale' => $this->locale,
            'name' => $this->name,
            'phone' => $this->profile->phone,
            'salut' => $this->profile->salut,
            'theme' => $this->theme,
            'username' => $this->username,
        ];
    }
}
