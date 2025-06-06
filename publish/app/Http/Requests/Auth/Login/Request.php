<?php

namespace App\Http\Requests\Auth\Login;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{
    /**
     *  Determine if the user is authorized to make this request.
     *
     *  @return bool
     */
    public function authorize(): bool
    {
        return config('enraiged.auth.allow_login') === true;
    }

    /**
     *  Get the validation rules that apply to the request.
     *
     *  @return array
     */
    public function rules(): array
    {
        $allow_username_login = config('enraiged.auth.allow_secondary_credential')
            && config('enraiged.auth.allow_username_login');

        return [
            'email' => $allow_username_login ? 'required|string' : 'required|string|email',
            'password' => 'required|string',
        ];
    }

    /**
     *  Prepare the credentials form authentication attempts.
     *
     *  @return bool
     */
    private function attempt(): bool
    {
        $this->session()->forget('secondaryLogin');

        $primary_credentials = collect($this->only('email', 'password'))
            ->merge(['is_active' => true])
            ->toArray();

        $secondary_credentials = collect($primary_credentials)
            ->merge(['username' => $this->get('email')])
            ->except('email')
            ->toArray();

        $allow_secondary_credentials = config('enraiged.auth.allow_secondary_credential') === true;

        return $this->attemptLoginWith($primary_credentials)
            || ($allow_secondary_credentials && $this->attemptLoginWith($secondary_credentials, true));
    }

    /**
     *  Execute an attempt to authenticate the provided credentials.
     *
     *  @param  array   $credentials
     *  @param  bool    $attemptSecondary = false
     *  @return bool
     */
    private function attemptLoginWith($credentials, $attemptSecondary = false): bool
    {
        $attempt = Auth::attempt($credentials, $this->boolean('remember'));

        //  This session value is read by the EnsureEmailIsVerified middleware
        //  in order to identify the correct email verification route to
        //  redirect the unverified user.
        //
        //  It is also referenced by the ip address tracking (if enabled) to
        //  store the login credential to the database.
        $this->session()->put('secondaryLogin', $attemptSecondary);

        if ($attempt && $attemptSecondary && Auth::user()->mustVerifySecondary) {
            //  Rejecting an unverified secondary will fail the login attempt
            //  even if the credentials are correct. The user will see a normal
            //  auth.failed error.
            if (config('enraiged.auth.reject_unverified_secondary') === true) {
                //  This event is used to trigger an email to the user to help
                //  them understand why the login failed.
                event(
                    new Failed(Auth::guard()->name, $this->user(), [
                        ...$credentials,
                        'attemptSecondary' => $attemptSecondary,
                    ])
                );

                Auth::logout();

                return false;
            }
        }

        return $attempt;
    }

    /**
     *  Attempt to authenticate the request credentials.
     *
     *  @return bool
     *
     *  @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): bool
    {
        $this->ensureIsNotRateLimited();

        if (! $this->attempt()) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        if (config('enraiged.auth.track_ip_addresses') === true) {
            $this->user()->trackIpAddress($this->ip());
        }

        return true;
    }

    /**
     *  Ensure the login request is not rate limited.
     *
     *  @return void
     *
     *  @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     *  Get the rate limiting throttle key for the request.
     *
     *  @return string
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
