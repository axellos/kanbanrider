<?php

namespace App\Providers;

use App\Actions\Auth\PasswordReset\GeneratePasswordResetLink;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(StatefulGuard::class, function () {
            return Auth::guard('api');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(GeneratePasswordResetLink $generatePasswordResetLink): void
    {
        ResetPassword::createUrlUsing($generatePasswordResetLink->execute(...));
    }
}
