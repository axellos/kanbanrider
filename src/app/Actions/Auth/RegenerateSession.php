<?php

namespace App\Actions\Auth;

use Illuminate\Http\Request;

final readonly class RegenerateSession
{
    public function execute(Request $request): void
    {
        $request->session()->regenerate();
    }
}
