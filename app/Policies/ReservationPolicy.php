<?php

namespace App\Policies;

use App\User;
use App\Reservation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
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
     * Determine whether the user can view the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Reservation  $reservation
     * @return mixed
     */
    public function create(User $user)
    {
        return true;  //as long as user isn't suspended
    }

    /**
     * Determine whether the user can create reservations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $user, Reservation $reservation)
    {
        return $user->id == $reservation->user_id;
    }

    /**
     * Determine whether the user can update the reservation.
     *
     * @param  \App\User  $user
     * @param  \App\Reservation  $reservation
     * @return mixed
     */
    public function calendar(User $user, Reservation $reservation)
    {
        return false; //if you aren't an admin, this is OFFFF LIMITS
    }

}
