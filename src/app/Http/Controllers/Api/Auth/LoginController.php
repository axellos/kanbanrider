<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\Login\LoginUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(LoginRequest $request, LoginUser $loginUser): Response
    {
        $loginUser->execute($request);

        return response()->noContent();
    }
}
