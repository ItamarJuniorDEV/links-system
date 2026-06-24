<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($file = $request->photo) {
            $data['photo'] = $file->store('photos', 'public');
        }

        $user->fill($data)->save();
        return back()->with('success', 'Perfil atualizado com sucesso.');
    }
}
