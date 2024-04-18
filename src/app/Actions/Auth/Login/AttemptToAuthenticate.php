<?php

namespace App\Actions\Auth\Login;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Services\Auth\LoginRateLimiter;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final readonly class AttemptToAuthenticate
{
    public function __construct(
        private LoginRateLimiter $limiter,
        private StatefulGuard $guard
    ) {
    }

    public function execute(LoginRequest $request): void
    {
        if (! $this->guard->attempt(
            $request->getCredentials(),
            $request->boolean('remember')
        )) {
            $this->throwFailedAuthenticationException($request);
        }
    }

    private function throwFailedAuthenticationException(Request $request): void
    {
        $this->limiter->increment($request);

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
