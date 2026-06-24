<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return to_route('dashboard');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Enviamos um novo link de verificação para o seu e-mail.');
    }
}
