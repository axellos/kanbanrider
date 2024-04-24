<?php

namespace App\Actions\Auth\EmailVerification;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;

final readonly class VerifyEmail
{
    public function execute(MustVerifyEmail $user): void
    {
        $user->markEmailAsVerified();

        event(new Verified($user));
    }
}
