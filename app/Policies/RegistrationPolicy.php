<?php

namespace App\Policies;

use App\User;
use App\Registration;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegistrationPolicy
{
    use HandlesAuthorization;
  
    public function before($current_user, $ability)
    {
        if ($current_user->suspended) {
          return false;
        }
      
        if ($current_user->role == 2) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the registration.
     *
     * @param  \App\User  $user
     * @param  \App\Registration  $registration
     * @return mixed
     */
    public function destroy(User $user, Registration $registration)
    {
        $user->id == $registration->user_id;
    }

}
