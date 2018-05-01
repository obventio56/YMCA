<?php

namespace App\Policies;

use App\User;
use App\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
     * Determine whether the user can view the event.
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function show(User $user, Event $event)
    {
        return $user->role == 1 || $event->public;
    }

    /**
     * Determine whether the user can create events.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 1;
    }

    /**
     * Determine whether the user can update the event.
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function update(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }
  
    public function edit(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }

    /**
     * Determine whether the user can delete the event.
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function destroy(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }
}
