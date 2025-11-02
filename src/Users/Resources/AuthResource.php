<?php

namespace Enraiged\Users\Resources;

use App\Http\Resources\JsonResource;
use Enraiged\Avatars\Resources\AvatarResource;
use Enraiged\Users\Enums\Roles;
use Illuminate\Http\Request;

class AuthResource extends JsonResource
{
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
            'email' => $this->email,
            'locale' => $this->locale,
            'name' => $this->name,
            'username' => config('enraiged.auth.allow_username_login')
                || (config('enraiged.auth.allow_secondary_credential') && $this->usernameIsEmailAddress)
                ? $this->username
                : null,
            'is_impersonating' => $request->session()->has('impersonate'),
            'avatar' => new AvatarResource($this->profile->avatar),
            'role' => Roles::find($this->role_id)->role(),
        ];
    }
}
