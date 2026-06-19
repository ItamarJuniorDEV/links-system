<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::unguard();

        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->environment('production') ? $rule->mixedCase()->uncompromised() : $rule;
        });
    }
}
