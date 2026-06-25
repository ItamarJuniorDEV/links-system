<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function request()
    {
        return view('auth.forgot-password');
    }

    public function email(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->validated());

        return $status === Password::ResetLinkSent
            ? back()->with('success', 'Enviamos o link de redefinição para o seu e-mail.')
            : back()->with('error', __($status));
    }

    public function reset(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function update(ResetPasswordRequest $request)
    {
        $status = Password::reset($request->validated(), function (User $user, string $password) {
            $user->forceFill(['password' => $password])->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
        });

        return $status === Password::PasswordReset
            ? to_route('login')->with('success', 'Senha redefinida. Faça login com a nova senha.')
            : back()->with('error', __($status));
    }
}
