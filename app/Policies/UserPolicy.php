<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
  
  
    //only staff and super users can see a list of users
    //and super users are already exempted
    public function index(User $current_user)
    {
      return $current_user->role == 1;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function show(User $current_user, User $user)
    {
        return $current_user->id == $user->id || $current_user->role == 1;
    }
  
    public function edit(User $current_user, User $user)
    {
        return $current_user->id == $user->id || $current_user->role == 1;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $current_user, User $user)
    {
        return $current_user->id == $user->id || $current_user->role == 1;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function destroy(User $current_user, User $user)
    {
        return $current_user->id == $user->id;
    }
}
