@extends('layouts.app')

@section('content')

<div class="container">
	<h3>Add A New Location</h3>
	<p>Enter the details for the new location below.</p>
	
  
  <form class="well" action="{{route('create-location')}}" method="POST">
    {{ csrf_field() }}
    <label>Name</label>
    <input type="text" name="title"/><br><br>
    <label>Description</label>
    <textarea cols="60" rows="12" name="description"></textarea>
    <label>Manager email</label>
    <input type="email" name="manager_email"/><br><br>
    <input class="btn btn-success" type="submit" value="Create New Location">
  </form>

</div>
@endsection