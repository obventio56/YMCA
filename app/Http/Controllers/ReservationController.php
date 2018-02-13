<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\ReservationSlot;
use App\Reservation;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;
use App\Mail\ReservationFacultyNotification;

class ReservationController extends Controller
{
  public function calendar() {
    if (Gate::allows('administrate-reservations')) {
      $reservations = Reservation::whereDate('start_time', '>', date('Y-m-d', strtotime('-1 year')) )->get();
      return view('reservations.calendar', ["reservations" => $reservations]);
    } else {
      return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  public function check_date(ReservationSlot $reservation_slot) {
    $hours_of_operation = json_decode($reservation_slot->hours_of_operation);
    $max_time = $this->convertToHoursMins($reservation_slot->max_time);
    $min_time = $this->convertToHoursMins($reservation_slot->time_interval);
    return view('reservations.pick-date', ["reservation_slot" => $reservation_slot,
                                           "hours_of_operation" => $hours_of_operation,
                                            "max_time" => $max_time,
                                            "min_time" => $min_time]);
  }
  
  public function check_time(Request $request, ReservationSlot $reservation_slot) {
    if (is_null($request->desired_date)) {
      return back()->withErrors(['desired_date' => ['Date cannot be blank']]);
    }
    
    //validate date
    //convert date format into something php understands. This is not intutive
    $desired_date = DateTime::createFromFormat('m-d-Y', $request->desired_date)->getTimestamp();
    if ($desired_date - time() <= $reservation_slot->reservation_window*86400) {
      $day_of_the_week = strtolower(date('l', $desired_date));
      $hours = $reservation_slot->get_hours_of_operation()->$day_of_the_week;
      $complete_slots = $this->generate_time_slots($reservation_slot, $desired_date, $hours);
      return view('reservations.check-time', ["reservation_slot" => $reservation_slot,
                                       "hours" => $hours,
                                       "date" => $desired_date,
                                       "complete_slots" => $complete_slots
                                      ]);
    } else {
      return back()->withErrors(['desired_date' => ['The date you selected is out of range for this reservation slot']]);
    }
  }
  
  
  public function new(ReservationSlot $reservation_slot, $desired_date_time) {
    $latest_possible_end_time = $this->latest_end_time($reservation_slot, $desired_date_time);
    $difference = ($latest_possible_end_time - $desired_date_time)/60;
    $max_time_slots_count = floor($difference / intval($reservation_slot->time_interval));
    $available_durations = $this->generate_available_durations($reservation_slot, $desired_date_time, $max_time_slots_count);
    return view('reservations.new', ["reservation_slot" => $reservation_slot,
                                       "date" => $desired_date_time,
                                       "available_durations" => $available_durations
                                      ]);
  }
  
  public function create(Request $request) {
    if (Gate::allows('create-reservation')) {
      $reservation_slot = ReservationSlot::find($request->reservation_slot_id);
      $start_time = strtotime($request->start_time);
      $end_time = $start_time + intval($request->length)*60;
      $admin = Auth::user()->role == 2;
      $time_validation = Reservation::validate_reservation_time($reservation_slot, $start_time, $end_time, $admin);
      if ($time_validation) {
        return $time_validation;
      }

      $reservation = new Reservation();
      $start_time = strtotime($request->start_time);
      $reservation->start_time = date("Y-m-d H:i:s", $start_time);
      $reservation->end_time = date("Y-m-d H:i:s", $start_time + intval($request->length)*60);
      $reservation->user_id = Auth::user()->id;
      $reservation->fill($request->all());

      $reservation->save();

      //send mail
      Mail::to(Auth::user())->send(new ReservationConfirmation($reservation));
      if ($reservation->reservation_slot->primary_email != "") {
        $faculty_mailer = Mail::to( explode(",", $reservation->reservation_slot->primary_email));

        $notification_emails = explode(",", $reservation->reservation_slot->notification_emails);
        if ($notification_emails[0] != "") {
          $faculty_mailer->cc($notification_emails)->send(new ReservationFacultyNotification($reservation));
        } else {
          $faculty_mailer->send(new ReservationFacultyNotification($reservation));
        } 
      }
      return redirect()->route('reservation-slots-index')->with('status', 'Successfully Created Reservation.');
    } else {
      return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  public function destroy(Reservation $reservation) {
    if (Gate::allows('manipulate-reservation', $reservation)) {
      $reservation->custom_destroy();
      return redirect()->route('reservation-slots-index')->with('status', 'Successfully Deleted Reservation.');
    } else {
      return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  //how long can this reservation be:
  //when is the next reservation?
  //when does the reservation slot close?
  //what is the max reservation time?
  //the max reservation time is the closest of those three times.
  public function latest_end_time(ReservationSlot $reservation_slot, $desired_date_time) {
    $times_to_compare = [];
    
    $next_reservation = $reservation_slot->reservations()->where("start_time", ">=", date('Y-m-d H:i:s', $desired_date_time))->oldest()->first(); 
    if (!is_null($next_reservation)) {
      array_push($times_to_compare, strtotime($next_reservation->start_time));
    }
    
    
    $day_of_the_week = strtolower(date('l', $desired_date_time));
    $hours = $reservation_slot->get_hours_of_operation()->$day_of_the_week;
    array_push($times_to_compare, strtotime(date('Y-m-j', $desired_date_time) . " " . $hours->close));
    
    array_push($times_to_compare, strtotime( '+' . $reservation_slot->max_time . ' minutes' ,  $desired_date_time));
    return min($times_to_compare);    
  }
  
  //How many time slots are there in a day?
  //Is each time slot full or available?
  //Return a list of start times for each slot in the day
  public function generate_time_slots(ReservationSlot $reservation_slot, $desired_date, $hours) {
    $open  = strtotime(date('Y-m-j', $desired_date) . " " . $hours->open);
    $close  = strtotime(date('Y-m-j', $desired_date) . " " . $hours->close);
    $difference = ($close - $open)/60;
    $complete_slots_count = floor($difference / intval($reservation_slot->time_interval));
    $start_time = $open;
    $complete_slots = [];
    for ($i = 0; $i < $complete_slots_count; $i++) {
      $end_time = strtotime( '+' . intval($reservation_slot->time_interval) . ' minutes' ,  $start_time);
      $existing_reservations_count = $reservation_slot->reservations()->where([
        ["start_time", "<", date('Y-m-d H:i:s', $end_time) ],
        ["end_time", ">", date('Y-m-d H:i:s', $start_time) ]
      ])->count();
      if ($existing_reservations_count > 0) {
        array_push($complete_slots, [$start_time, "taken"]);
      } else {
        array_push($complete_slots, [$start_time, "available"]);
      }
      $start_time = $end_time;
    }
    return $complete_slots;
  }
  
  public function generate_available_durations(ReservationSlot $reservation_slot, $start_time, $max_slot_count) {
    $available_durations = [];
    for ($time_slot = 1; $time_slot <= $max_slot_count; $time_slot++) {
      $minutes = $time_slot*intval($reservation_slot->time_interval);
      $hours_and_mintes = $this->convertToHoursMins($minutes);
      array_push($available_durations, [$minutes, $hours_and_mintes]);
    }
    return $available_durations;
  }
  
  
  //making grammar with if statements lol english sux
  function convertToHoursMins($time) {
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    if ($hours > 0 && $minutes > 0) {
      if ($hours > 1) {
        return $hours . " hours, and " . $minutes . " minutes";
      } else {
        return $hours . " hour, and " . $minutes . " minutes";
      }  
    } elseif ($minutes < 1) {
      if ($hours > 1) {
        return $hours . " hours";
      } else {
        return $hours . " hour";
      }
    } else {
      return $minutes . " minutes";
    }
  }
  
  
}
