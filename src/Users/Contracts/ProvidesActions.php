<?php

namespace Enraiged\Users\Contracts;

use Enraiged\Users\Collections\UserActionsCollection;

interface ProvidesActions
{
    /**
     *  Assemble and return the available actions.
     *
     *  @param  array|string   $items
     *  @return \Enraiged\Users\Collections\UserActionsCollection
     */
    public function actions(array|string $items): UserActionsCollection;
}
