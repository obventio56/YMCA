<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationSlotGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];
    public function reservation_slots()
    {
        return $this->belongsToMany('App\ReservationSlot', 'group_reservation_slots');
    }
    //
}
