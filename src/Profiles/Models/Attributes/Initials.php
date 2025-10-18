<?php

namespace Enraiged\Profiles\Models\Attributes;

trait Initials
{
    /**
     *  Return the characters for the avatar display.
     *
     *  @return string
     */
    public function avatarableCharacters()
    {
        return $this->initials;
    }

    /**
     *  @return string
     */
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->first_name, 0, 1).substr($this->last_name, 0, 1));
    }
}
