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
            ? __('The user :attribute has been updated.', ['attribute' => $this->attribute])
            : 'The user has been updated.';
    }
}
