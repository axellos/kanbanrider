<?php

namespace App\Actions\Auth;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

final readonly class InvalidateUserSession
{
    public function __construct(
        private AuthManager $authManager,
        private SessionManager $sessionManager
    ) {
    }

    public function execute(Request $request): void
    {
        $this->authManager->guard('api')->logout();

        $request->session()->invalidate();

        $this->sessionManager->invalidate();
        $this->sessionManager->regenerateToken();
    }
}
