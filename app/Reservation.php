<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class Reservation extends Model
{
  use SoftDeletes;

   
  protected $fillable = ["reservation_slot_id", "notes"];
  
  public function custom_destroy() {
    if ($this->for_event) {
      $this->event->custom_destroy(false); //false to not delete reservation (double jepordy)
    }
    return $this->delete();
  }
  
  public function reservation_slot() {
    return $this->belongsTo('App\ReservationSlot');
  }
  
  public function duration() {
    $start_time = strtotime($this->start_time);
    $end_time = strtotime($this->end_time);
    return ($end_time - $start_time)/60;
  }
  
  public function user() {
    return $this->belongsTo('App\User');
  }
  
  public function event() {
    return $this->hasOne('App\Event'); //it may or may not actually have an event
  }
  
  //validation here isn't right, but I'm reusing this in two controllers and laravel's solution is convoluted
  public static function validate_reservation_time(ReservationSlot $reservation_slot, $start_time, $end_time, $admin=false, $existing_id=false) {
    $existing_reservations_count = 0;
    if (!$existing_id) {
      $existing_reservations_count = $reservation_slot->reservations()->where([
        ["start_time", "<", date('Y-m-d H:i:s', $end_time) ],
        ["end_time", ">", date('Y-m-d H:i:s', $start_time) ]
      ])->count();
    } else {
      $existing_reservations_count = $reservation_slot->reservations()->where([
        ["start_time", "<", date('Y-m-d H:i:s', $end_time) ],
        ["end_time", ">", date('Y-m-d H:i:s', $start_time) ],
        ["id", "!=", $existing_id]
      ])->count();
    }
    
    if ($existing_reservations_count > 0) {
      return back()->withErrors(['length' => ['The length or start time you have chosen conflicts with existing reservations']]);
    }
    if (!$admin) { //if the "admin" is saving, the only thing we care about is conflicting reservaitons
      $difference = ($end_time - $start_time)/60;
      if ($difference > $reservation_slot->max_time) {
        return back()->withErrors(['length' => ["The length you have chosen is greater than the reservation slot's maximum length"]]);
      }
      $day_of_the_week = strtolower(date('l', $start_time));
      $hours = $reservation_slot->get_hours_of_operation()->$day_of_the_week;
      $closing_time = strtotime(date('Y-m-j', $start_time) . " " . $hours->close);
      if ($closing_time < $end_time) {
        return back()->withErrors(['length' => ["The start time and length you have chosen go past the reservation slot's close"]]);
      }
    }
    return false;
  }
}
