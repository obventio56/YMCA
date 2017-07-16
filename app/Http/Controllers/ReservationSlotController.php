<?php

namespace App\Http\Controllers;

use App\ReservationSlot;

use Illuminate\Http\Request;


class ReservationSlotController extends Controller
{
    public function index() {
      $reservation_slots = ReservationSlot::all();
      return return view('reservation_slots.index', ['reservation_slots' => $reservation_slots]);
    }
}
