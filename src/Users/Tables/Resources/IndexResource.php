<?php

namespace Enraiged\Users\Tables\Resources;

use Enraiged\Avatars\Resources\AvatarResource;
use Enraiged\Users\Resources\UserResource;

class IndexResource extends UserResource
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
            'avatar' => new AvatarResource($this->profile->avatar),
            'created_at' => $this->created->at['date'],
            'id' => $this->id,
            'is_active' => $this->is_active,
            'is_deleted' => $this->is_deleted,
            'email' => $this->email,
            'first_name' => $this->profile->first_name,
            'locale' => $this->locale,
            'last_name' => $this->profile->last_name,
            'name' => $this->name,
            'username' => $this->username,
        ];

        if ($this->resource->actions) {
            $resource['actions'] = $this->actions;
        }

        return $resource;
    }
}
