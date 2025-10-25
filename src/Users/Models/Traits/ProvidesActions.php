<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Users\Collections\UserActionsCollection;

trait ProvidesActions
{
    /** @var  array  The model actions. */
    public $actions;

    /**
     *  Assemble and return the available actions.
     *
     *  @param  array|string   $items
     *  @return \Enraiged\Users\Collections\UserActionsCollection
     */
    public function actions(array|string $items): UserActionsCollection
    {
        if (!is_array($items)) {
            $items = [$items];
        }

        $parameters = [
            'user' => $this->id,
        ];

        return (new UserActionsCollection($items))
            ->model($this, $parameters);
    }
}
