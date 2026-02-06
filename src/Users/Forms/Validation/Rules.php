<?php

namespace Enraiged\Users\Forms\Validation;

use Enraiged\Geo\Models\Country;
use Enraiged\Passwords\Forms\Validation\PasswordRules;
use Enraiged\Users\Enums\Roles;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait Rules
{
    /** @var  array  the validation rules that apply to the request. */
    protected $rules = [
        'birthday' => 'nullable|date',
        'country_id' => 'nullable|int|exists:countries,id',
        'is_active' => 'boolean',
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:12',
        'salut' => 'nullable|string',
        'theme' => 'array',
        'timezone' => 'nullable|timezone',
    ];

    /**
     *  Assemble and return the email validation rule for the request.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @param  \Enraiged\Users\Enums\Roles  $roles
     *  @return array
     */
    protected function validateEmailRule($user, $roles)
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
     *  Assemble and return the locale validation rule for the request.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @param  \Enraiged\Users\Enums\Roles  $roles
     *  @return array
     */
    protected function validateLocaleRule($user, $roles)
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
     *  Assemble and return the role_id validation rule for the request.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @param  \Enraiged\Users\Enums\Roles  $roles
     *  @return array|null
     */
    protected function validateRoleIdRule($user, $roles)
    {
        $admin = config('auth.providers.roles.admin', 'Administrator');

        if ($this->user()->role->is($roles::find($admin))) {
            return [
                'required',
                'int',
                'in:'.collect($roles::ids())->join(','),
            ];
        }

        return null;
    }

    /**
     *  Assemble and return the username validation rule for the request.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @param  \Enraiged\Users\Enums\Roles  $roles
     *  @return array
     */
    protected function validateUsernameRule($user, $roles)
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
        $roles = config('auth.providers.roles.enum', Roles::class);

        $rules = [];

        if ($this->routeIs('my.*')) {
            $user = $this->user();

        } else {
            $user = $this->user
                ? $model::findOrFail($this->user)
                : new $model;
        }

        $rules = [
            'password' => [
                $user->exists ? 'sometimes' : 'required',
                'confirmed',
                new PasswordRules],
        ];

        if ($this->user()->role->is($roles::find('Administrator'))) {
            $rules = [
                ...$rules,
                'is_hidden' => 'boolean',
                'is_protected' => 'boolean',
            ];
        }

        foreach (collect($this->all()) as $index => $value) {
            if (key_exists($index, $this->rules)) {
                $rules[$index] = $this->rules[$index];

            } else {
                $method = 'validate'.ucwords(Str::camel($index)).'Rule';

                if (method_exists($this, $method) && $rule = $this->{$method}($user, $roles)) {
                    $rules[$index] = $rule;
                }
            }
        }

        if ($this->filled('country_id') && $country = Country::find($this->get('country_id'))) {
            $rules['timezone'] = "{$rules['timezone']}:per_country,{$country->code}";
        }

        return $this->attribute
            ? collect($rules)
                ->only($this->attribute)
                ->toArray()
            : $rules;
    }
}
