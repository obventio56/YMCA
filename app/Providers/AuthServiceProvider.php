<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Reservation;

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
        'App\User' => 'App\Policies\UserPolicy',
        'App\Location' => 'App\Policies\LocationPolicy',
        'App\ReservationSlot' => 'App\Policies\ReservationSlotPolicy',
        'App\Reservation' => 'App\Policies\ReservationPolicy',
        'App\Event' => 'App\Policies\EventPolicy',
        'App\Registration' => 'App\Policies\RegistrationPolicy',
        'App\ReservationSlotGroup' => 'App\Policies\ReservationSlotGroupPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
     }
}
