<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! hash_equals(
            (string) $this->user()->getKey(),
            (string) $this->route('id'))
        ) {
            return false;
        }

        if (! hash_equals(
            sha1($this->user()->getEmailForVerification()),
            (string) $this->route('hash'))
        ) {
            return false;
        }

        return true;
    }
}
