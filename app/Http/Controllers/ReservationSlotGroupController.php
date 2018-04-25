<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservationSlotGroup;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreReservationSlotGroup;

class ReservationSlotGroupController extends Controller
{
  public function show_with_date(ReservationSlotGroup $group, Request $request) {
      $today = $request->date;
      $reservation_slots = $group->reservation_slots;
      $today = strtotime($today);
      $tomorrow = strtotime('+1 day', $today);
      return view('reservation_slot_groups.show', ["group" => $group,
                                                  "reservation_slots" => $reservation_slots,
                                                  "today" => $today,
                                                  "tomorrow" => $tomorrow]);

  }
  
  public function show(ReservationSlotGroup $group) {
      $today = strtotime(date('Y-m-d'));
      $tomorrow = strtotime('+1 day', $today);
      $reservation_slots = $group->reservation_slots;
      return view('reservation_slot_groups.show', ["group" => $group,
                                                  "reservation_slots" => $reservation_slots,
                                                  "today" => $today,
                                                  "tomorrow" => $tomorrow]);
  }
  
  public function index() {
      $groups = ReservationSlotGroup::all();
      return view('reservation_slot_groups.index', ["groups" => $groups]);

  }
  
  public function new() {
      return view('reservation_slot_groups.new');

  }
  
  public function create(StoreReservationSlotGroup $request) {
      $group = new ReservationSlotGroup;
      $group->fill($request->all());
      $group->save();
      return redirect()->route('reservation-slot-groups-index');

  }
  
  public function destroy(ReservationSlotGroup $group) {
      $group->delete();
      return redirect()->route('reservation-slot-groups-index');

  }
  
  public function check_date(ReservationSlotGroup $group) {
    return redirect()->route('check-date-for-reservation', ['reservation_slots' => implode(',', $group->reservation_slots->pluck('id')->toArray()) ]);
  }
  
  public function check_time(ReservationSlotGroup $group, Request $request) {
    return redirect()->route('check-time-for-reservation', ['reservation_slots' => implode(',', $group->reservation_slots->pluck('id')->toArray()), 
                                                            'desired_date' => $request->desired_date ]);
  }
}
