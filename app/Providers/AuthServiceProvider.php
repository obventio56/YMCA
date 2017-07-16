<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

      
        Gate::define('show-user', function ($user, $id) {
          
          return $user->role == 1 || $user->role == 2 || $user.id == $id;
        });
      
        Gate::define('edit-user', function ($user, $id) {
          return $user->role == 1 || $user->role == 2 || $user.id == $id;
        });
      
        Gate::define('update-user', function ($user, $id) {
          return $user->role == 1 || $user->role == 2 || $user.id == $id;
        });
      
        Gate::define('edit-user', function ($user, $id) {
          return $user->role == 1 || $user->role == 2 || $user.id == $id;
        });
      
        Gate::define('users-index', function ($user) {
          return $user->role == 1 || $user->role == 2;
        });
        //
    }
}
