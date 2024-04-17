<?php

namespace App\Http\Requests\Api\Auth;

use App\Dto\LoginAttemptDto;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ],
            'remember' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function toDto(): LoginAttemptDto
    {
        return new LoginAttemptDto(
            $this->input('email'),
            $this->input('password'),
            $this->getClientIp(),
            $this->boolean('remember')
        );
    }
}
