<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        if ($request->tryToRegister()) {
            return to_route('dashboard');
        }

        return back()->with('error', 'E-mail ou senha inválidos.');
    }
}
