<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Reservation;
use App\ReservationSlot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreEvent;

use Illuminate\Support\Facades\Mail;
use App\Mail\EventFacultyNotification;

class EventController extends Controller
{
 
  //for recurring events I need to convert english to strtotime intervals
  var $offset_lookup = [
    "day" => "+1 day",
    "week" => "+1 week",
    "biweek" => "+2 week",
    "month" => "+1 month"
  ];
  
  public function index(Request $request) {
    $events = Event::with(["reservation"])->get()
      ->where('public', true)
      ->where('reservation.start_time', '>', date('Y-m-d'))
      ->sortBy('reservation.start_time');
    if (Auth::user()->role == 2 || Auth::user()->role == 1) {
      $events = Event::with(["reservation"])->get()
        ->where('reservation.start_time', '>', date('Y-m-d'))
        ->sortBy('reservation.start_time');
    }
    
    if ($request->name) {
      $events = Event::with(["reservation"])->get()
        ->where('name', 'LIKE', '%' . $request->name . '%')
        ->where('public', true)
        ->get()
        ->where('reservation.start_time', '>', date('Y-m-d'))
        ->sortBy('reservation.start_time');
      if (Auth::user()->role == 2 || Auth::user()->role == 1) {
        $events = Event::with(["reservation"])->get()
          ->where('name', 'LIKE', '%' . $request->name . '%')
          ->get()
          ->where('reservation.start_time', '>', date('Y-m-d'))
          ->sortBy('reservation.start_time');
      }
    }
    //lazy egar loading
    $events->load(["reservation.reservation_slot","user"]);
    return view('events.index', ["events" => $events]);
  }
  
  public function name($name) {
    $events = Event::all()->where('name', $name)
      ->where('reservation.start_time', '>', date('Y-m-d'))
      ->sortBy('reservation.start_time');
    return view('events.search', ["events" => $events,
                                 "name" => $name]);
  }
  
  public function show(Event $event) {
    return view('events.show', [
      "event" => $event
    ]);
  }
  
  public function new() {
    $reservation_slots = ReservationSlot::all();
    return view('events.new', ["reservation_slots" => $reservation_slots]);
  }
  
  public function create(StoreEvent $request) {
      $times_occurring = 1; //defaults for non-recurring events
      $offset = "";
      $date = $request->date;

      if ($request->is_recurring) { //set parameters if recurring
        $times_occurring = intval($request->all()['recurring']['times']);
        $frequency = $request->all()["recurring"]["frequency"];
        $offset = $this->offset_lookup[$frequency];
      }

      for ($instance = 0; $instance < $times_occurring; $instance++) {
        $reservation_slot = ReservationSlot::find($request->all()["reservation"]["reservation_slot_id"]);
        $start_time = strtotime($date . " " . $request->start_time);
        $end_time = strtotime($date . " " . $request->end_time);
        //the last parameter below because only admin's can create events... and we don't want to contstrain them
        //based on the hours and max length
        $time_validation = Reservation::validate_reservation_time($reservation_slot, $start_time, $end_time, true);
        if ($time_validation) { //false if no errors
          return $time_validation;
        }

        $reservation = new Reservation;
        $reservation->fill($request->reservation); //nested parameters
        $reservation->start_time = date("Y-m-d H:i:s", $start_time);
        $reservation->end_time = date("Y-m-d H:i:s", $end_time);
        $reservation->for_event = true;
        $reservation->user_id = Auth::user()->id;
        
        if (!$reservation->save()) {
          return redirect()->back()->with('warning', ['There was an error saving the event']);
        }     

        $event = new Event;
        $event->fill($request->all());
        $event->reservation_id = $reservation->id;
        $event->user_id = Auth::user()->id;
        if ($event->save()) {
          if ($reservation->reservation_slot->primary_email != "") {
            $mailer = Mail::to( explode(",", $reservation->reservation_slot->primary_email));
            $notification_emails = explode(",", $reservation->reservation_slot->notification_emails);
            if ($notification_emails[0] != "") {
              $mailer = $mailer->bcc($notification_emails);
            }
            $mailer->send(new EventFacultyNotification($event));
          }
        } else {
          return redirect()->back()->with('warning', ['There was an error saving the event']);
          $reservation->delete(); //rollback reservation if event doesn't save
        }
      

        $date = date('Y-m-d', strtotime($offset, strtotime($date)));
      }

      
      return redirect()->route('events-index')->with('status', 'Successfully Created Event.');
  }
  
  public function edit(Event $event) {
    $reservation_slots = ReservationSlot::all();
    return view('events.edit', [
      "event" => $event,
      "reservation_slots" => $reservation_slots
    ]);
  }
  
  public function update(StoreEvent $request, Event $event) {
    $date = $request->date;
    $reservation_slot = ReservationSlot::find($request->all()["reservation"]["reservation_slot_id"]);
    $start_time = strtotime($date . " " . $request->start_time);
    $end_time = strtotime($date . " " . $request->end_time);
    //second to the last parameter below because only admin's can create events... and we don't want to contstrain them
    //based on the hours and max length
    //last parameter because we don't want to conflict with our unupdated selfs
    $time_validation = Reservation::validate_reservation_time($reservation_slot, $start_time, $end_time, true, $event->reservation->id);
    if ($time_validation) { //false if no errors
      return $time_validation;
    }

    $reservation = $event->reservation;
    $reservation->fill($request->reservation); //nested parameters
    $reservation->start_time = date("Y-m-d H:i:s", $start_time);
    $reservation->end_time = date("Y-m-d H:i:s", $end_time);
    $reservation->user_id = Auth::user()->id;
    $reservation->save();

    if (!$reservation->save()) {
      return redirect()->back()->with('warning', ['There was an error updating the event']);
    } 

    $event->fill($request->all());
    $event->reservation_id = $reservation->id;
    $event->user_id = Auth::user()->id;
    $event->save();

    if (!$event->save()) {
      return redirect()->back()->with('warning', ['There was an error updating the event']);
      $reservation->delete(); //rollback reservation if event doesn't save
    }

    return redirect()->route('events-index')->with('status', 'Successfully Updated Event.');
  }
  
  public function destroy(Event $event)  {
    $event->delete(); //sends cancelation email
    return redirect()->route('events-index')->with('status', 'Successfully Deleted Event.');
  }
}
