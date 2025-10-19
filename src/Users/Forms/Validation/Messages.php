<?php

namespace Enraiged\Users\Forms\Validation;

trait Messages
{
    /**
     *  Return the request success message.
     *
     *  @return string
     */
    public function message(): string
    {
        return $this->attribute
            ? "The user {$this->attribute} has been updated."
            : 'The user has been updated.';
    }
}
