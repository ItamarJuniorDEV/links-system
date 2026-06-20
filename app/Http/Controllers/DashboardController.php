<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $user = Auth::user();

        return view('dashboard', [
            'user' => $user,
            'links' => $user->links()->orderBy('sort')->get()
        ]);
    }
}
