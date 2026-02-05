<?php

namespace Enraiged\Network\Events;

use Enraiged\Network\Models\IpAddress;

class LoginAddress
{
    /**
     *  Create a instance of the LoginAddress event.
     *
     *  @param  \Enraiged\Network\Models\IpAddress  $ipAddress  The ip address model.
     *  @return void
     */
    public function __construct(public IpAddress $ipAddress)
    {}
}
