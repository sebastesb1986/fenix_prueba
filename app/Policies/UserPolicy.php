<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // Validar acceso a la lista de usuarios
    public function actions(User $user): bool
    {
        return $user->admin == 1;
    }

}
