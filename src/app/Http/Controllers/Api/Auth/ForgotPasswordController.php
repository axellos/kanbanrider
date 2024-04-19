<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\PasswordReset\SendPasswordResetLink;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(
        ForgotPasswordRequest $request,
        SendPasswordResetLink $sendPasswordResetLinkEmail
    ): JsonResponse {
        $status = $sendPasswordResetLinkEmail->execute($request->validated('email'));

        return response()->json([
            'message' => __($status),
        ]);
    }
}
