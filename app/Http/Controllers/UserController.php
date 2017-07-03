<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  
    $role_lookup = Array(
      "all" => 0,
      "staff" => 1
    )
      
    public function __construct()
    {
        $this->middleware('auth');
    } 
  
    public function index($role = 'all')
    {
      $users = App\Flight::where('role', $role_lookup[$role])
      return view('users.index', ['users' => $users, 'role' => ucfirst($role)]);
    }
}
