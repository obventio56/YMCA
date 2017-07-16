<?php
/*
User Controller:

create -> handled by registration
index -> display all users to admins
edit -> allow admins/the user to edit information
destroy -> remove user

*/


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
      
    public function __construct()
    {
        $this->role_lookup = Array(
          "all" => [0,1,2],
          "staff" => [1],
          "admin" => [2]
        );
      
        $this->middleware('auth');
    } 
  
    public function update_password_rules(array $data)
    {
      $messages = [
        'password.required' => 'Please enter password'
      ];

      $validator = Validator::make($data, [
            'password' => 'required|string|min:6|confirmed'
      ], $messages);

      return $validator; 
    }
  
    public function update_role_rules(array $data)
    {
      
      $validator = Validator::make($data, [
            'role' => 'current_user_is_admin' //custom validator in AppServiceProvider
      ]);

      return $validator; 
    }
  
    public function index($role = 'all')
    {
      $users = User::whereIn('role', $this->role_lookup[$role])->get();
      return view('users.index', ['users' => $users, 'role' => ucfirst($role)]);
    }
  
    public function edit(User $user) {
      $current_user = Auth::user();
      return view('users.edit', ['user' => $user, 'current_user' => $current_user]); 
    }
  
    public function update(User $user, Request $request) 
    {
      $updated_values = array_filter($request->all()); //array_filter removes null indecies
      
      
      //if the password is being updated, ensure it meets requirements and bycript it
      if (array_key_exists("password", $updated_values)) {
        $validator = $this->update_password_rules($updated_values);
        if ($validator->fails()) {
          return Redirect::back()
                ->withErrors($validator) // send back all errors to the login form
                ->withInput();
        } else {
          $updated_values["password"] = bcrypt($updated_values['password']);
          unset($updated_values["password_confirmation"]);
        }       
      }
      
      //if the role is being updated, make sure the current user is an admin
      if (array_key_exists("role", $updated_values)) {
        $validator = $this->update_role_rules($updated_values);
        if ($validator->fails()) {
          return Redirect::back()
                ->withErrors($validator) // send back all errors to the login form
                ->withInput();
        }
      }
      
      $user->update($updated_values);
      $user->save();
      
      $current_user = Auth::user();
      return view('users.edit', ['user' => $user, 'current_user' => $current_user]);
    }
  
    public function destroy(User $user) {
      $current_user = Auth::user();
      if ($current_user == $user) {
        Auth::logout();
      }
      $user->delete();
      return redirect()->route('landing');
    }
}
