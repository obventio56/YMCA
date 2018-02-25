@extends('layouts.app')

@section('content')

<div class="container" style="padding-top: 60px;">
	<h2>Sign up</h2>
	
	<form role="form" method="POST" action="{{ route('register') }}">
	  {{ csrf_field() }}
    
	  <p>If you want to register for events at the Carlisle YMCA you'll need to set up an account with our event registration system.  Just fill out the following information and you'll be on your way to signing up for some great classes and events.</p>

      <div class="{{ $errors->has('name') ? ' has-error' : '' }}">
          <label for="name">Name</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>

      <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email">Email</label>

          <input id="email" type="email" name="email" value="{{ old('email') }}" required>

          @if ($errors->has('email'))
              <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
      </div>

      <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
          <label for="password" >Password</label>

          <input id="password" type="password" class="form-control" name="password" required>

          @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
      </div>

      <div>
          <label for="password-confirm">Confirm Password</label>
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
      </div>
	
	  <div><input type="submit" class="btn btn-success" value="Sign Up"/></div>
  </form>
	
		<a href="/">Sign In</a><br>
    <a href="{{ route('password.request') }}">
        Forgot Your Password?
    </a>
</div>


@endsection
