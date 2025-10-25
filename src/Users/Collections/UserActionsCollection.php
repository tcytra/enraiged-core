<?php

namespace Enraiged\Users\Collections;

use Enraiged\Collections\ActionsCollection;
use Enraiged\Collections\RequestCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class UserActionsCollection extends ActionsCollection
{
    /** @var  string  The template json file path. */
    protected string $template = __DIR__.'/Templates/actions.json';

    /** @var  string  The routing prefix for the actions. */
    protected string $prefix = 'users.';

    /**
     *  Configure the routing for the collected actions.
     *
     *  @param  \Enraiged\Collections\RequestCollection  $request
     *  @param  \Illuminate\Database\Eloquent\Model|null  $model = null
     *  @param  string|null  $prefix = null
     *  @return \Enraiged\Collections\ActionsCollection
     */
    public function asRoutableActions(RequestCollection $request, ?Model $model = null, ?string $prefix = null)
    {
        $actions = [];

        $model = $model ?: $this->model;

        if ($model->isMyself) {
            foreach ($this->items as $action => $parameters) {
                $route = key_exists('route', $parameters) ? $parameters['route'] : [];

                $parameters['route'] = [
                    ...$route,
                    'name' => "my.profile.{$action}",
                ];

                if (Route::has($parameters['route']['name'])) {
                    $parameters['route']['url'] = route("my.profile.{$action}");

                    $actions[$action] = $parameters;
                }
            }

            $this->items = $this->getArrayableItems($actions);
        }

        return parent::asRoutableActions($request, $model, $prefix);
    }
}
