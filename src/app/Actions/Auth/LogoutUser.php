<?php

namespace App\Actions\Auth;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;

final readonly class LogoutUser
{
    public function __construct(
        private StatefulGuard $guard
    ) {
    }

    public function execute(Request $request): void
    {
        $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
