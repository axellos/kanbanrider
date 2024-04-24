<?php

namespace App\Actions\Auth\PasswordReset;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Validation\ValidationException;

final readonly class ResetPassword
{
    public function __construct(
        private PasswordBroker $passwordBroker,
        private UpdatePassword $updatePassword
    ) {
    }

    public function execute(string $email, string $password, string $token): string
    {
        $status = $this->passwordBroker->reset([
            'email' => $email,
            'password' => $password,
            'token' => $token,
        ], $this->updatePassword->execute(...));

        if ($status !== PasswordBroker::PASSWORD_RESET) {
            $this->throwPasswordResetFailedException($status);
        }

        return $status;
    }

    private function throwPasswordResetFailedException(string $status): void
    {
        throw ValidationException::withMessages([
            'email' => __($status),
        ]);
    }
}
