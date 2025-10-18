<?php

namespace Enraiged\Profiles\Models\Attributes;

trait Name
{
    /**
     *  @return string
     */
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    /**
     *  @return string
     */
    public function getNameReversedAttribute()
    {
        return $this->name(true, true);
    }

    /**
     *  @param  bool    $reversed = false
     *  @param  bool    $comma_separated = false
     *  @return string
     */
    public function name($reversed = false, $comma_separated = false)
    {
        if ($reversed) {
            $comma = $comma_separated ? ',' : '';

            return "{$this->last_name}{$comma} {$this->first_name}";
        }

        return "{$this->first_name} {$this->last_name}";
    }
}
