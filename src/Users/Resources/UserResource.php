<?php

namespace Enraiged\Users\Resources;

use Enraiged\Avatars\Resources\AvatarResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        $resource = [
            'id' => $this->id,
            'active' => $this->isActive,
            'alias' => $this->profile->alias,
            'email' => $this->email,
            'locale' => $this->locale,
            'name' => $this->name,
            'phone' => $this->profile->phone,
            'salut' => $this->profile->salut,
            'theme' => $this->theme,
            'username' => $this->username,
            'avatar' => (new AvatarResource($this->profile->avatar)),
            'created' => $this->created,
            'deleted' => !is_null($this->deleted_at)
                ? $this->deleted
                : false,
            'updated' => !is_null($this->updated_at)
                ? $this->updated
                : false,
        ];

        if ($this->isProtected) {
            $resource['protected'] = true;
        }

        return $resource;
    }
}
