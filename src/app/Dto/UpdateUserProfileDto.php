<?php

namespace App\Dto;

readonly class UpdateUserProfileDto
{
    public function __construct(
        public string $name,
        public string $email,
    ) {
    }
}
