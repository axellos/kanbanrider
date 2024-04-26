<?php

namespace App\Http\Requests\Api\Auth;

use App\Dto\UpdateUserProfileDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserProfileRequest extends FormRequest
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
                Rule::unique('users')->ignore($this->user()->id),
            ],
        ];
    }

    public function toDto(): UpdateUserProfileDto
    {
        return new UpdateUserProfileDto(
            $this->validated('name'),
            $this->validated('email'),
        );
    }
}
