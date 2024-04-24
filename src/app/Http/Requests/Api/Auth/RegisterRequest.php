<?php

namespace App\Http\Requests\Api\Auth;

use App\Dto\RegisterUserDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users'),
            ],
            'password' => [
                'required',
                'string',
            ],
        ];
    }

    public function toDto(): RegisterUserDto
    {
        return new RegisterUserDto(
            $this->validated('name'),
            $this->validated('email'),
            $this->validated('password')
        );
    }
}
