<?php

namespace Enraiged\Geo\Observers;

use Enraiged\Geo\Models\Address;

class AddressObserver
{
    /**
     *  Handle the Address creating event.
     *
     *  @param  \Enraiged\Geo\Models\Address  $address
     *  @return void
     */
    public function creating(Address $address)
    {
        if (!$address->addressable->addresses()->exists()) {
            $address->is_default = true;
        }
    }
}
