@extends('layouts.app')

@section("content")
<div class="container">
	<h2>Create New User</h2>
	<br/>
  <form class="well" action="{{route("create-user")}}" method="POST">
		
		{{ csrf_field() }}


		<div>
			<label>Name</label>
  		<input type="text" name="name" />
		</div>
  
		<div>
			<label>Email </label>
  		<input type="email" name="email" />
		</div>
	  
	  <div><br/><lable>This user is Super User (Full Admin): </lable>
	  <input type="radio" value="2" name="role"/></div><br/>

	  <div><br/><lable>This user is staff: </lable>
	  <input type="radio" value="1" name="role" /></div><br/>
		
		<div><br/><lable>This is a regular user: </lable>
	  <input type="radio" value="0" name="role" /></div><br/>
		
	
	  <input type="submit" value="Create User" class="btn btn-success"/>
	</form>
	
</div>
@endsection
