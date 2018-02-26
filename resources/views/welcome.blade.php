@extends('layouts.app')

@section('content')
  <h1 class="bigHeader">Welcome to our online event <br>registration system.</h1><br/>
	<h2 >Sign in</h2>
	<p>If you're looking for more information on any of the events or classes that we offer, please visit our <a href="http://www.carlislefamilyymca.org">website</a>.  </p>
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


@endsection