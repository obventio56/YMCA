<?php

namespace App\Policies;

use App\User;
use App\ReservationSlot;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationSlotPolicy
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
     * Determine whether the user can create reservationSlots.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can update the reservationSlot.
     *
     * @param  \App\User  $user
     * @param  \App\ReservationSlot  $reservationSlot
     * @return mixed
     */
    public function update(User $user, ReservationSlot $reservationSlot)
    {
        return $user->id === $reservationSlot->user_id;
    }
  
    public function edit(User $user, ReservationSlot $reservationSlot)
    {
        return $user->id === $reservationSlot->user_id;
    }

    /**
     * Determine whether the user can delete the reservationSlot.
     *
     * @param  \App\User  $user
     * @param  \App\ReservationSlot  $reservationSlot
     * @return mixed
     */
    public function destroy(User $user, ReservationSlot $reservationSlot)
    {
       return $user->id === $reservationSlot->user_id;
    }
}
