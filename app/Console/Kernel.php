<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Event;
use App\Reservation;

use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationReminder;
use App\Mail\ReservationReminder;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      
        $schedule->call(function () {
          
          $three_days_from_now = strtotime("+3 days", time()); //this is default from the old app, every three days
          
          $reservations = Reservation::where([
            ["start_time", "<", date('Y-m-d H:i:s', $three_days_from_now) ],
            ["start_time", ">", date('Y-m-d H:i:s') ]
          ])->get();
          
          
          foreach ($reservations as $reservation) {
            if ($reservation->for_event) {
              foreach ($reservation->event->registrations as $registration) {
                  Log::info(var_dump($registration));
                  //Mail::to($registration->user)->send(new RegistrationReminder($registration));
              } 
            } else {
                //Mail::to($reservation->user)->send(new ReservationReminder($reservation));
            }
          }
   
      
        })->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
