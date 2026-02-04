<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Forms\Builders\FormBuilder;
use Enraiged\Users\Forms\UserForm;
use Illuminate\Http\Request;

trait ProvidesForm
{
    /**
     *  Create and return a form builder instance against this model.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Enraiged\Forms\Builders\FormBuilder
     */
    public function form(Request $request): FormBuilder
    {
        $form = (new UserForm($request, $this))
            ->fieldIf('email', ['label' => 'Primary Email'], $this->allowSecondaryCredential)
            ->fieldIf('username', ['label' => 'Secondary Email or Username', 'type' => 'text'], $this->allowUsernameLogin)
            ->removeIf('username', !$this->allowSecondaryCredential);

        return $this->exists
            ? $form->edit('users.update', ['user' => $this->id])
            : $form->create('users.store');
    }
}
