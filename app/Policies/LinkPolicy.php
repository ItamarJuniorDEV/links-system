<?php

namespace App\Policies;

use App\Models\Link;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LinkPolicy
{
    public function atualizar(User $user, Link $link)
    {
        return $link->user_id === $user->id
        ? Response::allow()
        : Response::deny('Você não tem permissão para acessar esse link');
    }
}
