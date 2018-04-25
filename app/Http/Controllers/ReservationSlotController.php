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
  
    public function index(Request $request) {
      $current_user = Auth::user();
      
      //if regular user
      $reservation_slots = false;
      $reservations = false;
      $your_reservations = $current_user->reservations()
        ->where( "start_time", ">", date('Y-m-d H:i:s', time()) )
        ->get()
        ->sortBy('start_time');
      if ($current_user->role == 2) { //if admin
        $reservation_slots = ReservationSlot::all();
        $reservations = Reservation::where( "start_time", ">", date('Y-m-d H:i:s', time()) )
          ->get()
          ->sortBy('start_time');
        $reservations->load(["reservation_slot", "user", "event"]);
      } elseif ($current_user->role == 2) { //staff
        $reservation_slots = ReservationSlot::all();
      }
      if ($request->title && $reservation_slots) {
        $reservation_slots = ReservationSlot::where('title', 'LIKE', '%' . $request->title . '%')->get();
      }
      
      //lazy loading
      
      $your_reservations->load(["reservation_slot", "user", "event"]);
      
      return view('reservation_slots.index', 
      [
        'raquetball_group_id' => env('RACQUETBALL_GROUP', 2),
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
      $reservation_slot = new ReservationSlot() ;
      $reservation_slot->fill($request->all());     
      $reservation_slot->hours_of_operation = json_encode($request->hours_of_operation);
      $reservation_slot->user_id = Auth::user()->id;
      $reservation_slot->location_id = intval($request->location_id);
      $reservation_slot->save();
      if ($reservation_slot->reservation_slot_groups()->sync($request->groups)) {
        return redirect()->route('reservation-slots-index');
      } else {
        $reservation_slot->delete();
        return back()->withErrors(['groups' => ['There was an error assigning your reservation groups']]);
      }
    }
  
    public function edit(Request $request, ReservationSlot $reservation_slot) {
      $locations = Location::all();
      $reservation_slot_groups = ReservationSlotGroup::all();
      $hours_of_operation = json_decode($reservation_slot->hours_of_operation); //db doesn't autoparse json
      return view('reservation_slots.edit', ["locations" => $locations, 
                                             'reservation_slot' => $reservation_slot, 
                                             'hours_of_operation' => $hours_of_operation,
                                             "reservation_slot_groups" => $reservation_slot_groups]);
    }
  
    public function update(StoreReservationSlot $request, ReservationSlot $reservation_slot) {
      $reservation_slot->fill($request->all());
      $reservation_slot->hours_of_operation = json_encode($request->hours_of_operation);
      $reservation_slot->save();
      if ($reservation_slot->reservation_slot_groups()->sync($request->groups)) {
        return redirect()->route('reservation-slots-index');
      } else {
        $reservation_slot->delete();
        return back()->withErrors(['groups' => ['There was an error assigning your reservation groups']]);
      }

      return redirect()->route('reservation-slots-index');
    }
  
    public function destroy(ReservationSlot $reservation_slot) {
      $reservation_slot->delete();
      return redirect()->route('reservation-slots-index');
    }
}
