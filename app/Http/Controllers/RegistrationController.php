<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Event;
use App\Registration;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;
use App\Mail\RegistrationAdminNotification;

class RegistrationController extends Controller
{
  public function create(Event $event) {
    $registration = new Registration;
    $registration->event_id = $event->id;
    $registration->user_id = Auth::user()->id;
    
    //some custom validation, so I'm doing it here
    if (Auth::user()->registrations->where("event_id", $event->id)->count() > 0 ) {
      return back()->with('warning', 'You are already registered for this event');
    } elseif ($event->registrations->count() >= $event->available_spots) {
      return back()->with('warning', 'The event is full');
    } elseif (!$event->open_to_register()) {
      return back()->with('warning', 'The event is not yet open for registration');
    }
        
    $registration->save();
    
    //send mail
    Mail::to($registration->user)->send(new RegistrationConfirmation($registration));
    Mail::to($registration->event->notification_email)->send(new RegistrationAdminNotification($registration));
    
    return redirect()->route('show-event', [$event]);
  }
    
  public function destroy(Registration $registration) {
    $registration->delete();
    return back();
  }
  
}
