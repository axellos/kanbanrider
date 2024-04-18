<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LogoutUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    public function logout(Request $request, LogoutUser $logoutUser): Response
    {
        $logoutUser->execute($request);

        return response()->noContent();
    }
}
