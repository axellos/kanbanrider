<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\EmailVerification\SendEmailVerificationNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function sendVerifyLinkEmail(
        Request $request,
        SendEmailVerificationNotification $sendEmailVerificationNotification
    ): JsonResponse {
        $sendEmailVerificationNotification->execute($request->user());

        return response()->json([
            'message' => 'Verification email sent!',
        ]);
    }
}
