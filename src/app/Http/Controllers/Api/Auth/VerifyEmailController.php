<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\EmailVerification\SendEmailVerificationNotification;
use App\Actions\Auth\EmailVerification\VerifyEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\VerifyEmailRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify(VerifyEmailRequest $request, VerifyEmail $verifyEmail): JsonResponse
    {
        $verifyEmail->execute($request->user());

        return response()->json([
            'message' => __('auth.email_verification.verified'),
        ]);
    }

    public function sendVerifyLinkEmail(
        Request $request,
        SendEmailVerificationNotification $sendEmailVerificationNotification
    ): JsonResponse {
        $sendEmailVerificationNotification->execute($request->user());

        return response()->json([
            'message' => __('auth.email_verification.sent'),
        ]);
    }
}
