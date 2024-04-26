<?php

namespace App\Actions\User;

use App\Actions\Auth\EmailVerification\SendEmailVerificationNotification;
use App\Dto\UpdateUserProfileDto;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;

final readonly class UpdateUserProfileInformation
{
    public function __construct(
        private SendEmailVerificationNotification $sendEmailVerificationNotification,
    ) {
    }

    public function execute(User $user, UpdateUserProfileDto $dto): User
    {
        $hasNewEmail = $user->email !== $dto->email;

        $user->fill([
            'name' => $dto->name,
            'email' => $dto->email,
        ]);

        if ($hasNewEmail) {
            $user->forceFill([
                'email_verified_at' => null,
            ]);
        }

        $user->save();

        if ($hasNewEmail && $user instanceof MustVerifyEmail) {
            $this->sendEmailVerificationNotification->execute($user);
        }

        return $user->refresh();
    }
}
