<?php

namespace App\Actions\Auth\PasswordReset;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Validation\ValidationException;

final readonly class SendPasswordResetLink
{
    public function __construct(
        private PasswordBroker $passwordBroker
    ) {
    }

    public function execute(string $email): string
    {
        $status = $this->passwordBroker->sendResetLink([
            'email' => $email,
        ]);

        if ($status !== PasswordBroker::RESET_LINK_SENT) {
            $this->throwPasswordResetLinkSendFailureException($status);
        }

        return $status;
    }

    private function throwPasswordResetLinkSendFailureException(string $status): void
    {
        throw ValidationException::withMessages([
            'email' => __($status),
        ]);
    }
}
