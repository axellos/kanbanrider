<?php

namespace App\Actions\Auth;

use App\Dto\RegisterUserDto;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Hashing\Hasher;

final readonly class RegisterUser
{
    public function __construct(
        private Hasher $hasher,
        private StatefulGuard $guard
    ) {
    }

    public function execute(RegisterUserDto $dto, bool $login = false): User
    {
        $user = User::query()->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $this->hasher->make($dto->password),
        ]);

        event(new Registered($user));

        if ($login) {
            $this->guard->login($user);
        }

        return $user;
    }
}
