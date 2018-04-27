<?php

namespace App\Policies;

use App\User;
use App\ReservationSlotGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationSlotGroupPolicy
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
     * Determine whether the user can create reservationSlotGroups.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the reservationSlotGroup.
     *
     * @param  \App\User  $user
     * @param  \App\ReservationSlotGroup  $reservationSlotGroup
     * @return mixed
     */
    public function update(User $user, ReservationSlotGroup $reservationSlotGroup)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the reservationSlotGroup.
     *
     * @param  \App\User  $user
     * @param  \App\ReservationSlotGroup  $reservationSlotGroup
     * @return mixed
     */
    public function destroy(User $user, ReservationSlotGroup $reservationSlotGroup)
    {
        return true;
    }
}
