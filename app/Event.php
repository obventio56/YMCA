<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
  use SoftDeletes;
  protected $fillable = ["fee", "description", "name", "available_spots", "notification_email", "public", "registration_window"];
    
  public function custom_destroy($destroy_reservation=true) {
    foreach ($this->registrations as $registration) {
      $registration->delete();
    }
    if ($destroy_reservation) {
      $this->reservation->delete();
    }
    return $this->delete();
  }
  
  public function user() {
    return $this->belongsTo('App\User');
  }
  
  public function reservation() { //this is belgons to because events has the foreign key
    return $this->belongsTo('App\Reservation');
  }
  
  public function registrations() {
    return $this->hasMany('App\Registration');
  }
  
  public function full() {
    $registration_count = $this->registrations->count();
    if ($registration_count >= $this->available_spots) {
      return true;
    }
    return false;
  }
  
  public function open_to_register() {
    $registration_window = $this->registration_window;
    if (is_null($registration_window)) {
      return true;
    } 
    $start_date = strtotime($this->reservation->start_time);
    $difference = ($start_date - time())/86400;
    if ($difference < $registration_window) {
      return true;
    }
    return false;
  }
  
  public function remaining_spots() {
    return $this->available_spots - $this->registrations->count();
  }
    //
}
