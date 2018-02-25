<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReservationSlotGroup;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationSlot extends Model
{
  use SoftDeletes;
  
  protected $fillable = ['location_id', 'title', 'description', 'primary_email', 'notification_emails', 'time_interval', 'max_time', 'reservation_window', 'notes', 'public'];

  //I don't know if this is bad form but I'm going to do it anyways:
  
  public function get_hours_of_operation() {

    return json_decode($this->hours_of_operation);
    
  }
  
  public function set_hours_of_operation(Array $hours_of_operation) {
    $this->hours_of_operation = json_encode($hours_of_operation);
  }
  
  public function location()
  {
    return $this->belongsTo('App\Location');
  }
  
  public function reservations()
  {
    return $this->hasMany('App\Reservation');
  }
  public function reservation_slot_groups()
  {
        return $this->belongsToMany('App\ReservationSlotGroup', 'group_reservation_slots');
  }
  
  public function custom_destroy() {
    foreach($this->reservations as $reservation) {
      $reservation->custom_destroy();
    }
    foreach ($this->reservation_slot_groups as $group) {
      $group->pivot->delete();
    }
    return $this->delete();
  }
  
  public function has_reservation_slot_group(ReservationSlotGroup $reservation_slot_group) {
    if (!is_null($this->reservation_slot_groups)) {
      if ($this->reservation_slot_groups->where('id', $reservation_slot_group->id)->count() > 0) {
        return true;
      }
    }
    return false;
  }
}
