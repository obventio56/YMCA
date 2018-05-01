<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use App\Http\Requests\StoreLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
  
    public function index() //this isn't authorize because users can see location information in other ways
    {
      $locations = Location::all();
      return view('locations.index', ['locations' => $locations]);
    }
  
    public function new() //i don't care if anyone can get to the form
    {
      return view('locations.new');
    }
  
    public function create(StoreLocation $request)
    {
        $location = new Location;
        $location->fill($request->all());
        $location->save();

        return redirect()->route('locations-index')->with("status", "Successfully created location.");
    }
  
    public function edit(Location $location)
    {
      return view('locations.edit', ['location' => $location]);
    }
  
    public function update(StoreLocation $request, Location $location)
    {
        $location->update(array_filter($request->all()));
        return redirect()->route('locations-index')->with("status", "Successfully updated location.");

    }
  
    public function destroy(Location $location) {
      $location->delete();
      return redirect()->route('locations-index')->with("status", "Successfully destroyed location.");
    }
}
