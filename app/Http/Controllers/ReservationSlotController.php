<?php

namespace App\Http\Controllers;

use App\ReservationSlot;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Location;
use App\Reservation;
use App\ReservationSlotGroup;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreReservationSlot;


class ReservationSlotController extends Controller
{
  
    public function index() {
      $current_user = Auth::user();
      
      //if regular user
      $reservation_slots = false;
      $reservations = false;
      $your_reservations = $current_user->reservations->where( "start_time", ">", date('Y-m-d H:i:s', time()) );
      if ($current_user->role == 2) { //if admin
        $reservation_slots = ReservationSlot::all();
        $reservations = Reservation::all()->where( "start_time", ">", date('Y-m-d H:i:s', time()) );
      } elseif ($current_user->role == 2) { //staff
        $reservation_slots = ReservationSlot::all();
      }
      
      return view('reservation_slots.index', 
      [
        'reservation_slots' => $reservation_slots,
        'reservations' => $reservations,
        'your_reservations' => $your_reservations,
      ]);
    }
  
    public function new() {
      $locations = Location::all();
      $reservation_slot_groups = ReservationSlotGroup::all();
      return view('reservation_slots.new', ["locations" => $locations,
                                           "reservation_slot_groups" => $reservation_slot_groups]);
    }
  
    public function create(StoreReservationSlot $request) {
      if (Gate::allows('manipulate-reservation-slot')) {
        $reservation_slot = new ReservationSlot() ;
        $reservation_slot->fill($request->all());
        $reservation_slot->hours_of_operation = json_encode($request->hours_of_operation);
        $reservation_slot->user_id = Auth::user()->id;
        $reservation_slot->location_id = intval($request->location_id);
        $reservation_slot->reservation_slot_groups()->sync($request->groups);
        $reservation_slot->save();

        return redirect()->route('reservation-slots-index');
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      }
    }
  
    public function edit(ReservationSlot $reservation_slot) {
      if (Gate::allows('manipulate-reservation-slot')) {
        $locations = Location::all();
        $reservation_slot_groups = ReservationSlotGroup::all();
        $hours_of_operation = json_decode($reservation_slot->hours_of_operation); //db doesn't autoparse json
        return view('reservation_slots.edit', ["locations" => $locations, 
                                               'reservation_slot' => $reservation_slot, 
                                               'hours_of_operation' => $hours_of_operation,
                                               "reservation_slot_groups" => $reservation_slot_groups]);
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      } 
    }
  
    public function update(StoreReservationSlot $request, ReservationSlot $reservation_slot) {
      if (Gate::allows('manipulate-reservation-slot')) {
        $reservation_slot->fill($request->all());
        $reservation_slot->hours_of_operation = json_encode($request->hours_of_operation);
        $reservation_slot->reservation_slot_groups()->sync($request->groups);
        $reservation_slot->save();

        return redirect()->route('edit-reservation-slot', $reservation_slot);
       } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      }
    }
  
    public function destroy(ReservationSlot $reservation_slot) {
      if (Gate::allows('manipulate-reservation-slot')) {
        $reservation_slot->custom_destroy();
        return redirect()->route('reservation-slots-index');
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      }
    }
}
