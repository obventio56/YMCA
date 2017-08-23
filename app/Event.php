<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventCancelationNotification;

class Event extends Model
{
  use SoftDeletes;
  protected $fillable = ["fee", "description", "name", "available_spots", "notification_email", "public", "registration_window"];
    
  public function custom_destroy($destroy_reservation=true) {
    
    //this email happens here to prevent copied code
    
    //I apologize that this is so ugly
    //I spent a good bit of time finding the right way to no avail ;(
    $registrations = $this->registrations;
    $registration_emails = Array();
    foreach($registrations as $registration) {
      array_push($registration_emails, $registration->user->email);
    }
    array_merge($registration_emails, explode(",", $this->reservation->reservation_slot->notification_emails));
    Mail::to($this->reservation->reservation_slot->primary_email)
      ->bcc($registration_emails)
      ->send(new EventCancelationNotification($this));
    
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
