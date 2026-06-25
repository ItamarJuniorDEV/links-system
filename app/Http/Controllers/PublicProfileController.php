<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Visitor;
use Illuminate\Http\Request;

use function Illuminate\Support\defer;

class PublicProfileController extends Controller
{
    /**
     * Página pública do perfil (linkssystem.com.br/usuario).
     */
    public function __invoke(Request $request, string $handler)
    {
        $user = User::where('handler', $handler)->firstOrFail();

        $data = Visitor::from($request);

        defer(fn () => $user->profileViews()->create($data));

        return view('profiles.show', [
            'user' => $user,
            'links' => $user->links()->orderBy('sort')->get(),
        ]);
    }
}
