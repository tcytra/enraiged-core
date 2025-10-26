<?php

namespace Enraiged\Users\Responses;

use Enraiged\Collections\RequestCollection;
use Enraiged\Users\Resources\UserResource;
use Inertia\Response as InertiaResponse;

class UserInertiaResponse
{
    /** @var  array  The actions to include in the response. */
    protected static array $actions = [
        'impersonate' => 'p-button-text text-help',
        'show' => 'p-button-text text-info',
        'edit' => 'p-button-text text-warning',
        'delete' => 'p-button-text text-danger',
    ];

    /**
     *  Return am Inertia Response with the full user context.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @param  \Enraiged\Users\Models\User  $user
     *  @param  string  $component
     *  @return \Inertia\Response
     */
    public static function Render($request, $user, $component): InertiaResponse
    {
        $request = RequestCollection::from($request);

        $actions = $user->actions(self::$actions)
            ->asRoutableActions($request)
            ->toArray();

        $props = [
            'actions' => $actions,
            'allowSecondaryCredential' => $user->allowSecondaryCredential,
            'allowSelfDelete' => $user->allowSelfDelete,
            'allowUsernameLogin' => $user->allowUsernameLogin,
            'isMyProfile' => $user->isMyself,
            'isProtectedUser' => $user->isProtected,
            'mustVerifyEmail' => $user->mustVerifyEmail,
            'mustVerifySecondary' => $user->mustVerifySecondary,
            'user' => new UserResource($user),
        ];

        return inertia($component, $props);
    }
}
