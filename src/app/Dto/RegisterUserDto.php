<?php

namespace App\Dto;

use SensitiveParameter;

readonly class RegisterUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        #[SensitiveParameter]
        public string $password,
    ) {
    }
}
