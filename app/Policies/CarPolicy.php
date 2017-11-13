<?php

namespace App\Policies;

use App\User;
use App\Models\Car;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->inRole('administrator')) {
            return true;
        }
    }

    public function create(User $user)
    {
      return ($user->inRole('administrator') == 1) ? true : false;
    }
}
