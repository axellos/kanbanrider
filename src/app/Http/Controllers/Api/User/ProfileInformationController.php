<?php

namespace App\Http\Controllers\Api\User;

use App\Actions\User\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\UpdateUserProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileInformationController extends Controller
{
    public function update(
        UpdateUserProfileRequest $request,
        UpdateUserProfileInformation $updateUserProfileInformation
    ): JsonResource {
        $user = $updateUserProfileInformation->execute($request->user(), $request->toDto());

        return new UserResource($user);
    }
}
