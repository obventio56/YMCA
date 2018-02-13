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
    }
  
    public function new() {
      return view('users.new');
    }
  
    public function create(Request $request) {
      $user = new User;
      $user->fill($request->all());
      $user->save();
      return redirect()->route('users-index')->with('message', 'New user successfully created');;
    }
  
    public function set_password_form(User $user) {
      return view('users.set-password-form', ['user' => $user]);
    }
  
    public function set_password(User $user, Request $request) {
      $validator = $this->update_password_rules($request->all());
      if ($validator->fails()) {
        return Redirect::back()
              ->withErrors($validator) 
              ->withInput();
      } else {
        $user->password = bcrypt($request->all()['password']);
        $user->save();
      }       
      return redirect()->route('login');
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
  
    public function index(Request $request, $role = 'all')
    {
      if (Gate::allows('users-index')) {
        $users = User::whereIn('role', $this->role_lookup[$role])->orderBy('name')->paginate(15);
        if ($request->name) {
          $users = User::whereIn('role', $this->role_lookup[$role])
            ->where('name', 'LIKE', '%' . $request->name . '%')
            ->orderBy('name')->paginate(1000);
        }
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

        $updated_values = $request->all();

        //if the password is being updated, ensure it meets requirements and bycript it
        if (!is_null($updated_values["password"])) {
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
          $user->role = $updated_values["role"];
        }
        
        $validator = Validator::make($updated_values, [
            'email' => 'unique:users,email'.$user->id
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                  ->withErrors($validator) // send back all errors to the login form
                  ->withInput();
        }
        
        $user->update( array_filter($updated_values)); //array_filter removes null password
        
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
      if (Gate::allows('delete-user', $user)) {
        $current_user = Auth::user();
        $redirect = redirect()->route('users-index')->with('status', 'User successfully deleted');
        if ($current_user == $user) {
          Auth::logout();
          $redirect = redirect()->route('home')->with('status', 'Your account has been deleted');
        }
        $user->delete();
        return $redirect;
      } else {
        return redirect()->route('events-index')->with('warning', 'You are not authorized to complete that action');
      }
    }
}
