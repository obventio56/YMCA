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
use Illuminate\Support\Facades\Gate;

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
      if (Gate::allows('users-index')) {
        $users = User::whereIn('role', $this->role_lookup[$role])->get();
        return view('users.index', ['users' => $users, 'role' => ucfirst($role)]);
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      }
    }
  
    public function edit(User $user) {
      if (Gate::allows('manipulate-user', $user)) {
        $current_user = Auth::user();
        return view('users.edit', ['user' => $user, 'current_user' => $current_user]);
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      }
    }
  
    public function update(User $user, Request $request) 
    {
      if (Gate::allows('manipulate-user', $user)) {

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
        
        //sorry this is gross, don't know a better way to do it...
        //it is protected by auth.
        if (!isset($updated_values["suspended"]) && $user->suspended){
          $user->suspended = false;
        }
        
        $user->save();

        return redirect()->route('edit-user', [$user])->with('status', 'User successfully updated');
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      } 
    }
  
    public function destroy(User $user) {
      if (Gate::allows('manipulate-user', $user)) {
        $current_user = Auth::user();
        $redirect = redirect()->route('users-index')->with('status', 'User successfully deleted');
        if ($current_user == $user) {
          Auth::logout();
          $redirect = redirect()->route('landing')->with('status', 'Your account has been deleted');
        }
        $user->delete();
        return $redirect;
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      }
    }
}
