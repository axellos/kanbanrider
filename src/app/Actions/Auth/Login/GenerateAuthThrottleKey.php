<?php

namespace App\Actions\Auth\Login;

use Illuminate\Support\Str;

final readonly class GenerateAuthThrottleKey
{
    public function execute(string $email, string $ip): string
    {
        return Str::lower($email).'|'.$ip;
    }
}
