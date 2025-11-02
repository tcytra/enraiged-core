<?php

namespace Enraiged\Users\Resources;

use App\Http\Resources\JsonResource;
use Enraiged\Avatars\Resources\AvatarResource;
use Enraiged\Users\Enums\Roles;
use Illuminate\Http\Request;

class UserResource extends JsonResource
{
    /**
     *  Transform the resource into an array.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @return array
     */
    public function toArray(Request $request): array
    {
        $roles = config('auth.providers.roles.enum', Roles::class);

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
            'role' => $roles::find($this->role_id)->role(),
            'status' => $this->status(),
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

    /**
     *  Determine the dynamic status of the user.
     *
     *  @return string
     */
    protected function status(): string
    {
        if ($this->isDeleted) {
            return 'deleted';
        }

        if (!$this->isActive) {
            return 'inactive';
        }

        return 'active';
    }
}
