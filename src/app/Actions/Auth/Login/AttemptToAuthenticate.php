<?php

namespace App\Actions\Auth\Login;

use App\Dto\LoginAttemptDto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

final readonly class AttemptToAuthenticate
{
    public function __construct(
        private GenerateAuthThrottleKey $generateAuthThrottleKey
    ) {
    }

    public function execute(LoginAttemptDto $dto): void
    {
        $throttleKey = $this->generateAuthThrottleKey->execute($dto->email, $dto->ip);

        if (! Auth::guard('api')->attempt($dto->getCredentials(), $dto->remember)) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($throttleKey);
    }
}
