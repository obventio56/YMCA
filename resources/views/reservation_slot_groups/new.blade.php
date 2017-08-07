@extends('layouts.app')

@section('content')

<div class="container">
	<h3>Add A New Reservation Slot Group</h3>
	
  
  <form class="well" action="{{route('create-reservation-slot-group')}}" method="POST">
    {{ csrf_field() }}
    <label>Title</label>
    <input type="text" name="title"/><br><br>
    <input class="btn btn-success" type="submit" value="Create New Location">
  </form>

</div>
@endsection