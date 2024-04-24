<?php

namespace App\Actions\Auth\EmailVerification;

use Illuminate\Contracts\Auth\MustVerifyEmail;

final readonly class GenerateEmailVerificationLink
{
    public function execute(MustVerifyEmail $user): string
    {
        return url(config('frontend.url').'/auth/verify-email')
            .'?'
            .http_build_query([
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]);
    }
}
