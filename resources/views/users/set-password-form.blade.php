@extends('layouts.app')

@section('content')

<div class="container" style="padding-top: 60px;">
	<h2>Set password for {{$user->name}}</h2>
	
  <p>We've recently migrated our site and we are requiring users to choose a new password.</p>
	
  <form role="form" method="POST" action="{{ route('set-password', [$user]) }}">
    {{ csrf_field() }}
	
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
	
    <div><input type="submit" class="btn btn-success" value="Set Password"/></div>
	</form>
	  <a href="{{ route('register') }}">Sign Up</a><br>
    <a href="{{ route('password.request') }}">
        Forgot Your Password?
    </a>
  </div>
 @endsection

