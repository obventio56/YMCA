@extends('layouts.app')

@section("content")
<div class="container">
	<h2>Edit {{$user->name}}</h2>
	<br/>
  <form class="well" action="{{route("update-user", [$user])}}" method="POST">
	{{ csrf_field() }}


		<div>
			<label>Name</label>
  		<input type="text" name="name" value="{{$user->name}}"/>
		</div>
  
		<div>
			<label>Email </label>
  		<input type="email" name="email" value="{{$user->email}}"/>
		</div>
	
		<div>
			<label>Password</label>
	  	<input type="password" name="password"/>
			@if ($errors->has('password'))
        <span class="help-block">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
      @endif
		</div>
	
		<div>
			<label>Confirm Password</label>
			<input type="password" name="password_confirmation"/>
		</div>
	  
	  @if ($current_user->role == 2)
	  <div><br/><lable>This user is Super User (Full Admin): </lable>
	  <input type="radio" value="2" name="role" {{ $user->role_radio_button_status()[2] }}/></div><br/>

	  <div><br/><lable>This user is staff: </lable>
	  <input type="radio" value="1" name="role" {{ $user->role_radio_button_status()[1] }}/></div><br/>
		
		<div><br/><lable>This is a regular user: </lable>
	  <input type="radio" value="0" name="role" {{ $user->role_radio_button_status()[0] }}/></div><br/>
	  @endif
	
	  <input type="submit" value="Update this User" class="btn btn-success"/>
	</form>
	
	<h3>Remove This User</h3>
	
	<p><a href="{{route('destroy-user', [$user])}}">Remove this user</a></p>
	
</div>
@endsection
