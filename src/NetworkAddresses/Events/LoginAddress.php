<?php

namespace Enraiged\NetworkAddresses\Events;

use Enraiged\NetworkAddresses\Models\IpAddress;

class LoginAddress
{
    /**
     *  Create a instance of the LoginAddress event.
     *
     *  @param  \Enraiged\NetworkAddresses\Models\IpAddress  $ipAddress  The ip address model.
     *  @return void
     */
    public function __construct(public IpAddress $ipAddress)
    {}
}
