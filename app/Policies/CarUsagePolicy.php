<?php

namespace App\Policies;

use App\User;
use App\Models\CarUsage;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarUsagePolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->inRole('administrator')) {
            return true;
        }
    }
}
