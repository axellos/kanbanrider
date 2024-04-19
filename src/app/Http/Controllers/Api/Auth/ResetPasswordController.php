<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\PasswordReset\ResetPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    public function reset(
        ResetPasswordRequest $request,
        ResetPassword $resetPassword
    ): JsonResponse {
        $status = $resetPassword->execute(
            $request->validated('email'),
            $request->validated('password'),
            $request->validated('token')
        );

        return response()->json([
            'message' => __($status),
        ]);
    }
}
