<?php

namespace Enraiged\Users\Forms\Validation;

use Enraiged\Passwords\Forms\Validation\PasswordRules;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait Rules
{
    /** @var  array  the validation rules that apply to the request. */
    protected $rules = [
        'name' => 'required|string|max:255',
        'salut' => 'nullable|string',
        'theme' => 'array',
    ];

    /**
     *  Assemble and return the locale validation rule for the request.
     *
     *  @return array
     */
    protected function validateLocaleRule()
    {
        $locales = collect(config('enraiged.locales'))
            ->keys()
            ->join(',');

        return [
            'sometimes',
            'required',
            'string',
            'min:2',
            'max:2',
            "in:{$locales}",
        ];
    }

    /**
     *  Assemble and return the email validation rule for the request.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return array
     */
    protected function validateEmailRule($user)
    {
        $table = $user->getTable();

        return [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            Rule::unique($table, 'email')->ignore($user->id),
        ];
    }

    /**
     *  Assemble and return the username validation rule for the request.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return array
     */
    protected function validatePasswordRule($user)
    {
        return ['required', 'confirmed', new PasswordRules];
    }

    /**
     *  Assemble and return the username validation rule for the request.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return array
     */
    protected function validateUsernameRule($user)
    {
        $rules = ['nullable', 'string'];

        if ($user->allowSecondaryCredential) {
            $table = $user->getTable();

            $rule = $user->exists
                ? Rule::unique($table, 'username')->ignore($user->id)
                : Rule::unique($table, 'username');

            return $user->allowUsernameLogin
                ? [...$rules, 'max:255', $rule]
                : ['email', 'max:255', $rule];
        }

        return $rules;
    }

    /**
     *  Get the validation rules that apply to the request.
     *
     *  @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $model = config('auth.providers.users.model');

        $rules = [];

        if ($this->routeIs('my.*')) {
            $user = $this->user();

        } else {
            $user = $this->user
                ? $model::findOrFail($this->user)
                : new $model;
        }

        foreach (collect($this->all()) as $index => $value) {
            if (key_exists($index, $this->rules)) {
                $rules[$index] = $this->rules[$index];

            } else {
                $method = 'validate'.ucwords(Str::camel($index)).'Rule';

                if (method_exists($this, $method)) {
                    $rules[$index] = $this->{$method}($user);
                }
            }
        }

        return $this->attribute
            ? collect($rules)
                ->only($this->attribute)
                ->toArray()
            : $rules;
    }
}
