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
    if (Gate::allows('reservaiton-slot-group')) {
      $today = $request->date;
      $reservation_slots = $group->reservation_slots;
      $today = strtotime($today);
      $tomorrow = strtotime('+1 day', $today);
      return view('reservation_slot_groups.show', ["group" => $group,
                                                  "reservation_slots" => $reservation_slots,
                                                  "today" => $today,
                                                  "tomorrow" => $tomorrow]);
    } else {
      return redirect->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  public function show(ReservationSlotGroup $group) {
    if (Gate::allows('reservaiton-slot-group')) {
      $today = strtotime(date('Y-m-d'));
      $tomorrow = strtotime('+1 day', $today);
      $reservation_slots = $group->reservation_slots;
      return view('reservation_slot_groups.show', ["group" => $group,
                                                  "reservation_slots" => $reservation_slots,
                                                  "today" => $today,
                                                  "tomorrow" => $tomorrow]);
    } else {
      return redirect->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  public function index() {
    if (Gate::allows('reservaiton-slot-group')) {
      $groups = ReservationSlotGroup::all();
      return view('reservation_slot_groups.index', ["groups" => $groups]);
    } else {
      return redirect->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  public function new() {
    if (Gate::allows('reservaiton-slot-group')) {
      return view('reservation_slot_groups.new');
    } else {
      return redirect->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  public function create(StoreReservationSlotGroup $request) {
    if (Gate::allows('reservaiton-slot-group')) {
      $group = new ReservationSlotGroup;
      $group->fill($request->all());
      $group->save();
      return redirect()->route('reservation-slot-groups-index');
    } else {
      return redirect->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
  
  public function destroy(ReservationSlotGroup $group) {
    if (Gate::allows('reservaiton-slot-group')) {
      $group->delete();
      return redirect()->route('reservation-slot-groups-index');
    } else {
      return redirect->route('events-index')->with('warning', 'You are not authorized to complete that action');
    }
  }
}
