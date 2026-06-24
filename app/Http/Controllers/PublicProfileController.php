<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProfileController extends Controller
{
    /**
     * Página pública do perfil (linkssystem.com.br/usuario).
     */
    public function __invoke(string $handler)
    {
        $user = User::where('handler', $handler)->firstOrFail();

        return view('profiles.show', [
            'user' => $user,
            'links' => $user->links()->orderBy('sort')->get(),
        ]);
    }
}
