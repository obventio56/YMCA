<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
  use SoftDeletes;
  
    protected $fillable = ['title', 'description', 'manager_email'];
  
    public function user()
    {
        return $this->belongsTo('App\User');
    }
  
    public function reservation_slots()
    {
        return $this->hasMany('App\ReservationSlot');
    }
  
    public function custom_destroy() {
      foreach ($this->reservation_slots as $reservation_slot) {
        $reservation_slot->custom_destroy();
      }
      return $this->delete();
    }
}
