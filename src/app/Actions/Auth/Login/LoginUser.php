<?php

namespace App\Actions\Auth\Login;

use App\Actions\Auth\RegenerateSession;
use App\Http\Requests\Api\Auth\LoginRequest;

final readonly class LoginUser
{
    public function __construct(
        private EnsureRequestIsNotRateLimited $ensureRequestIsNotRateLimited,
        private AttemptToAuthenticate $attemptToAuthenticate,
        private RegenerateSession $regenerateSession
    ) {
    }

    public function execute(LoginRequest $request): void
    {
        $this->ensureRequestIsNotRateLimited->execute($request);
        $this->attemptToAuthenticate->execute($request->toDto());
        $this->regenerateSession->execute($request);
    }
}
