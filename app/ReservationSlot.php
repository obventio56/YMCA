<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReservationSlotGroup;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationSlot extends Model
{
  use SoftDeletes;
  
  protected $fillable = ['location_id', 'title', 'description', 'primary_email', 'notification_emails', 'time_interval', 'max_time', 'reservation_window', 'notes', 'public'];


  
  public static function boot()
  {
      parent::boot();

      static::deleted(function ($reservation_slot) {

          $reservation_slot->reservations()->delete();
        
          foreach ($reservation_slot->reservation_slot_groups as $group) {
            $group->pivot->delete();
          }

      });
  }
  
  //I don't know if this is bad form but I'm going to do it anyways:
  
  public function get_hours_of_operation() {

    return json_decode($this->hours_of_operation);
    
  }
  
  public function get_notification_emails() {
    $emails = json_decode($this->notification_emails);
    if (is_null($emails)) {
      $this->notification_emails = json_encode(explode(",",$this->notification_emails));
      $this->save();
    }
    
    
    return json_decode($this->notification_emails);
      
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
  
  
  public function has_reservation_slot_group(ReservationSlotGroup $reservation_slot_group) {
    if (!is_null($this->reservation_slot_groups)) {
      if ($this->reservation_slot_groups->where('id', $reservation_slot_group->id)->count() > 0) {
        return true;
      }
    }
    return false;
  }
}

/*
>>> foreach (ReservationSlot::all() as $reservation_slot)
>>> $reservation_slot->notification_emails = json_encode(explode(",",$reservation_slot->notification_emails));
=> "[""]"
>>> $reservation_slot->save();
=> true
>>> endforeach
*/
