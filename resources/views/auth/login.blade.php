@extends('layouts.app')

@section('content')

<div class="container" style="padding-top: 60px;">
	<h2>Sign in</h2>
	
  <p>If you want to register for events at the Carlisle YMCA you'll need to have an account with our event registration system.  Login with the form below or <a href="{{ route('register') }}">Sign Up Here!</a></p>
	
  <form role="form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
      <label for="email">Email</label>
      <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
      @if ($errors->has('email'))
        <span class="help-block">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
      @endif
    </div>
	
	  <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
      <label for="password">Password</label>
	    <input id="password" type="password" class="form-control" name="password" required>
      @if ($errors->has('password'))
          <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
      @endif
    </div>
	
	  <div><br/><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    <br/><br/></div>
	
    <div><input type="submit" class="btn btn-success" value="Sign In"/></div>
	</form>
	  <a href="{{ route('register') }}">Sign Up</a><br>
    <a href="{{ route('password.request') }}">
        Forgot Your Password?
    </a>
  </div>
 @endsection

