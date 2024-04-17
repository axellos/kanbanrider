<?php

namespace App\Actions\Auth\Login;

use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

final readonly class EnsureRequestIsNotRateLimited
{
    public function __construct(
        private GenerateAuthThrottleKey $generateAuthThrottleKey
    ) {
    }

    public function execute(LoginRequest $request): void
    {
        $throttleKey = $this->generateAuthThrottleKey->execute(
            $request->input('email'),
            $request->getClientIp(),
        );

        if (! RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', ['seconds' => $seconds]),
        ]);
    }
}
