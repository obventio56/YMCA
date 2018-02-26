<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
    //this function handle's people signing on again from their old account
    //if the user exists but their password is "false", make them reset it
    //I think using false is safe bc the hashing function shouldn't be capable of producing false
  
    protected function sendFailedLoginResponse(Request $request)
    {
      
      if (User::where(['email' => $request->email, 'password' => "false"])->first()) {
        return redirect('/password/reset');
      } else {
        
        $errors = [$this->username() => trans('auth.failed')];
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
      }
    }
  

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
