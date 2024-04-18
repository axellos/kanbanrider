<?php

namespace App\Actions\Auth\Login;

use App\Services\Auth\LoginRateLimiter;
use Illuminate\Http\Request;

final readonly class PrepareAuthenticatedSession
{
    public function __construct(
        private LoginRateLimiter $limiter
    ) {
    }

    public function execute(Request $request): void
    {
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        $this->limiter->clear($request);
    }
}
