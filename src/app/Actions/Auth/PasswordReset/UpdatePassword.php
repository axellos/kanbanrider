<?php

namespace App\Actions\Auth\PasswordReset;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Str;

final readonly class UpdatePassword
{
    public function __construct(
        private Hasher $hasher
    ) {
    }

    public function execute(User $user, string $password): void
    {
        $user->forceFill([
            'password' => $this->hasher->make($password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));
    }
}
