<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function index()
    {
      $locations = Location::all();
      return view('locations.index', ['locations' => $locations]);
    }
  
    public function new()
    {
      return view('locations.new');
    }
  
    public function create(Request $request)
    {
      $location = new Location;
      $location->fill($request->all());
      $location->user_id = Auth::user()->id;
      $location->save();
      
      return redirect()->route('locations-index');
    }
  
    public function edit(Location $location)
    {
      return view('locations.edit', ['location' => $location]);
    }
  
    public function update(Request $request, Location $location)
    {
      $location->update(array_filter($request->all()));
      
      return redirect()->route('locations-index');
    }
  
    public function destroy(Location $location) {
      $location->delete();
      return redirect()->route('locations-index');
    }
}
