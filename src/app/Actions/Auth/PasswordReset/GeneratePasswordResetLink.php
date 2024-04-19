<?php

namespace App\Actions\Auth\PasswordReset;

use App\Models\User;

final readonly class GeneratePasswordResetLink
{
    public function execute(User $user, string $token): string
    {
        return url(config('frontend.url').'/auth/reset-password')
            .'?'
            .http_build_query([
                'email' => $user->getEmailForPasswordReset(),
                'token' => $token,
            ]);
    }
}
