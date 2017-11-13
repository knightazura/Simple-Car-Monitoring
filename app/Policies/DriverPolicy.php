<?php

namespace App\Policies;

use App\User;
use App\Driver;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->inRole('administrator')) {
            return true;
        }
    }
}
