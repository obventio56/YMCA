<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Event;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'suspended',
    ];

  
     protected $dispatchesEvents = [
        'saving' => UserSaving::class
     ];
  
     protected $dates = ['deleted_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
  
    public function reservations()
    {
      return $this->hasMany('App\Reservation');
    }
  
    public function events()
    {
      return $this->hasMany('App\Event');
    }
  
    public function registrations()
    {
      return $this->hasMany('App\Registration');
    }
  
    public function reservation_slots()
    {
      return $this->hasMany('App\ReservationSlot');
    }
  
    public function registered(Event $event) {
      if ($this->registrations->where('event_id', $event->id)->count() > 0) {
        return true;
      }
      return false;
    } 
  
    protected $hidden = [
        'password', 'remember_token',
    ];
  
    public function role_radio_button_status() {
      $initial_values = Array(
        0=>'',
        1=>'',
        2=>''
      );
      $initial_values[$this->role] = 'checked';
      return $initial_values;
    }
}
