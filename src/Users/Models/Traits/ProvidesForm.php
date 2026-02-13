<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Forms\Builders\FormBuilder;
use Enraiged\Users\Enums\Roles;
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
        $roles = config('auth.providers.roles.enum', Roles::class);

        $form = (new UserForm($request, $this))
            ->fieldIf('email', ['label' => 'Primary Email'], $this->allowSecondaryCredential)
            ->fieldIf('username', ['label' => 'Secondary Email or Username', 'type' => 'text'], $this->allowUsernameLogin)
            ->removeIf('username', !$this->allowSecondaryCredential);

        if ($this->exists) {
            if ($this->isMyself) {
                $form
                    ->precontent('account_section', 'Update your account profile information and email address.')
                    ->precontent('password_section', 'Provide and confirm your new account password.');
            }

            return $form
                ->field('password', ['autocomplete' => 'new-password', 'placeholder' => 'Leave blank to keep password', 'required' => false])
                ->field('password_confirmation', ['placeholder' => null, 'required' => false])
                ->removeIf('is_hidden', !$this->is_hidden)
                ->removeIf('is_protected', !$this->is_protected)
                ->disabledIf('role_id', $this->is_protected && $this->role->is($roles::find('Administrator')))
                ->disabledIf('is_protected', $this->is_protected)
                ->value('name', $this->name)
                ->edit('users.update', ['user' => $this->id]);
        }

        return $form
            ->create('users.store');
    }
}
