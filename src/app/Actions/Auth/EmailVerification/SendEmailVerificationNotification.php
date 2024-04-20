<?php

namespace App\Actions\Auth\EmailVerification;

use Illuminate\Contracts\Auth\MustVerifyEmail;

final readonly class SendEmailVerificationNotification
{
    public function execute(MustVerifyEmail $user): void
    {
        if ($user->hasVerifiedEmail()) {
            return;
        }

        $user->sendEmailVerificationNotification();
    }
}
