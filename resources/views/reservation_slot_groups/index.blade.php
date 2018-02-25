@extends('layouts.app')

@section('content')

<div class="container">
	<h3>Reservation Slot Groups</h3>
	<p>You'll find all of your reservation slot groups listed below. These groups may be used to organize similar reservation slots (e.g. racquetball courts)</p>
	<a href="{{route("new-reservation-slot-group")}}" class="btn btn-success" style="margin-right: 9px;">Create Group</a>
	@if (Auth::user()->role == 2)
		<a href="{{route('calendar-of-reservations')}}" class="btn" style="margin-right: 9px;">Calendar Overview</a>
		<a href="{{route('reservation-slots-index')}}" class="btn" style="margin-right: 9px;">All Reservations</a>
		<br/><br/>
	@endif
	<br/><br/>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Title</th>
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach ($groups as $group)
	    <tr>
	    	<td style="width: 120px;"><a href="{{route('show-reservation-slot-group', [$group])}}">{{ $group->title }}</b></td>
        <td><a class="btn btn-danger pull-right" href="{{ route("destroy-reservation-slot-group", [$group] ) }}" >Delete Group</a>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
</div>

@endsection