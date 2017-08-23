<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Reservation;
use App\ReservationSlot;

use App\Event;
use App\Registration;


//There is a file structure for authorization but I don't think it's too
//complicated to leave it all here.
//I don't prevent anyone from viewing the related edit pages but
//if an unauthorized person actually takes action they will be deined.

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

      
      
        //user gates
        Gate::define('manipulate-user', function ($current_user, $user) {
          
          return ($current_user->role == 1 || $current_user->role == 2 || $current_user->id == $user->id) && !$current_user->suspended;
        });
      
        Gate::define('users-index', function ($user) {
          return ($user->role == 1 || $user->role == 2) && !$user->suspended;
        });
       
        //Location gates
        Gate::define('manipulate-location', function ($user) {
          return ($user->role == 2) && !$user->suspended;
        });
  
        //reservation slot gates
        Gate::define('manipulate-reservation-slot', function ($user, ReservationSlot $reservation_slot) {
          return ($user->role == 2 || ($user->role == 1 && $reservation_slot->user == $user)) && !$user->suspended;
        });
      
        Gate::define('create-reservation-slot', function ($user) {
          return ($user->role == 2 || $user->role == 1) && !$user->suspended;
        });
   
        //reservation gates
        Gate::define('manipulate-reservation', function ($user, Reservation $reservation) {
          return ($user->role == 2 || $user->id == $reservation->user->id) && !$user->suspended;
        });
      
        Gate::define('administrate-reservations', function ($user) {
          return ($user->role == 2) && !$user->suspended;
        });
      
        //event gates
        Gate::define('create-event', function ($user) {
          return ($user->role == 1 || $user->role == 2) && !$user->suspended;
        });
      
        Gate::define('manipulate-event', function ($user, Event $event) {
          return ($user->role == 2 || $user->id == $event->user->id) && !$user->suspended;
        });
      
        Gate::define('show-event', function ($user, Event $event) {
          return ($user->role == 2 || $user->role == 1 || $event->public) && !$user->suspended;
        });
      
        //registration gates      
        Gate::define('destroy-registration', function ($user, Registration $registration) {
          return ($user->role == 2 || $user->id == $registration->user->id) && !$user->suspended;
        });
      
        //reservation slot group gates
        Gate::define('reservation-slot-group', function ($user) {
          return ($user->role == 2) && !$user->suspended;
        });
     }
}
