<?php

namespace App\Dto;

use SensitiveParameter;

readonly class LoginAttemptDto
{
    public function __construct(
        public string $email,
        #[SensitiveParameter]
        public string $password,
        public string $ip,
        public bool $remember = false,
    ) {
    }

    public function getCredentials(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
