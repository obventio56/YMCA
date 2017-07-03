<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
  
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
  
    public function create_location(Request $request)
    {
      $location = new Location;
      
      $location->title = $request->title;
      $location->description = $request->description;
      $location->user_id = Auth::user()->id;
      
      $location->save();
        
      return redirect('locations');
    }
}
