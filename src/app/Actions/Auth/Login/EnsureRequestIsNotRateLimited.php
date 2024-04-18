<?php

namespace App\Actions\Auth\Login;

use App\Services\Auth\LoginRateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final readonly class EnsureRequestIsNotRateLimited
{
    public function __construct(
        private LoginRateLimiter $limiter,
    ) {
    }

    public function execute(Request $request): void
    {
        if (! $this->limiter->tooManyAttempts($request)) {
            return;
        }

        event(new Lockout($request));

        $this->throwThrottleException($request);
    }

    private function throwThrottleException(Request $request): void
    {
        $seconds = $this->limiter->availableIn($request);

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', ['seconds' => $seconds]),
        ]);
    }
}
