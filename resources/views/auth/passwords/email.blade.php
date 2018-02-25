

@extends('layouts.app')

@section('content')

<div class="container" style="padding-top: 60px;">
	<h2>Reset password</h2>
	
  <p>We've recently migrated our site and we are requiring users to choose a new password.</p>
	
    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <label for="email">E-Mail Address:</label>

        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required><br><br>

        <div class="form-group">
                <button type="submit" class="btn btn-info">
                    Send Password Reset Link
                </button>
        </div>
    </form>
  </div>
 @endsection

