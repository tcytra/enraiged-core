<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Collections\ActionsCollection;
use Enraiged\Users\Actions\UserActions;

trait ProvidesActions
{
    /** @var  array  The model actions. */
    public $actions;

    /**
     *  Assemble and return the available actions.
     *
     *  @param  array|string   $items
     *  @return \Enraiged\Users\Actions\UserActions
     */
    public function actions(array|string $items): ActionsCollection
    {
        if (!is_array($items)) {
            $items = [$items];
        }

        $parameters = [
            'user' => $this->id,
        ];

        return (new UserActions($items))
            ->model($this, $parameters);
    }
}
