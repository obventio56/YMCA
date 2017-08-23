@extends("layouts.app")

@section("content")
<div class="container">
	<h3>Reservation Slots and Reservations</h3>
	<p>You'll find all reservation slots that are available to reserve listed below.</p>
	
@if (Auth::user()->role == 2 || Auth::user()->role == 1)
	<a class="btn btn-success" style="margin-right: 9px;" href="{{ route('new-reservation-slot') }}" >Create New Reservation Slot</a>
@endif
	
@if (Auth::user()->role == 2)
	<a href="{{route('calendar-of-reservations')}}" class="btn" style="margin-right: 9px;">Calendar Overview</a>
	<a href="{{route('reservation-slot-groups-index')}}" class="btn" style="margin-right: 9px;">Reservation Slot Groups</a>
	<br/><br/>
@endif
		
@if ($reservation_slots)
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Reservation Slot</th>
	      <th>Description/Location</th>
	      <th>Primary Email</th>
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach ($reservation_slots as $reservation_slot)
	    <tr>
	    	<td style="width: 120px;"><b><a href="{{route('check-date-for-reservation', [$reservation_slot])}}">{{$reservation_slot->title}}</a></b></td>
	      <td>
	      	<p>{{$reservation_slot->description}}</p>
	      	<p>Copy and paste the following URL anywhere that you need to link to registration for this reservation slot:<br/><br/>
		      	<span style="color: #ff0000;">{{route('check-date-for-reservation', [$reservation_slot])}}</span>
	      	</p>
	      </td>
	      <td>{{$reservation_slot->primary_email}}<br/><br/>{{str_replace(",", "\n", $reservation_slot->notification_emails)}}</td>
				<td style="width: 270px;"><a class="btn btn-danger pull-right" href="{{route("destroy-reservation-slot", [$reservation_slot])}}">Delete Reservation Slot</a>
					<a class="btn btn-info pull-right" style="margin-right: 9px;" href="{{route("edit-reservation-slot", [$reservation_slot])}}">Edit Reservation Slot</a>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
	<br/>
@endif
		
@if ($reservations)
	<h3>Current Reservations</h3>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Reservation Slot/Room</th>
	      <th>Reservation Details</th>
	      <th>Cancel Registration</th>
	    </tr>
	  </thead>
	  <tbody>
			@foreach ($reservations as $reservation)
	    <tr>
	    	<td style="width: 120px;"><b><a href="{{ route('check-date-for-reservation', [$reservation->reservation_slot]) }}">{{$reservation->reservation_slot->title}}</a></b></td>
	      <td>
					<p>User: <a href="{{route('edit-user', $reservation->user)}}">{{$reservation->user->name }}</a></p>
	      	<p>{{$reservation->reservation_slot->description}}</p>
					@if ($reservation->for_event)
					<p>This reservation is attached to an <a href="{{route('show-event', [$reservation->event] )}}">event.</a></p>
					@endif
	      	<p>{{ date("l F j, Y", strtotime($reservation->start_time)) }} at {{ date("g:i A", strtotime($reservation->start_time)) }}<br/>
	      	Length: {{$reservation->duration()}} minutes</p>
	      </td>
	      <td style="width: 270px;">
					@if ($reservation->for_event)
						<a href="{{route('destroy-reservation', $reservation)}}" confirm="This reservation is attached to an event. Deleting this reservation will also delete the event and cancel all registrations." class="btn btn-danger pull-right">Cancel Reservation</a>
					@else 
						<a href="{{route('destroy-reservation', $reservation)}}" confirm="Are you sure you want to DELETE this reservation?" class="btn btn-danger pull-right">Cancel Reservation</a>
					@endif
				</td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
@endif
		
@if ($your_reservations)
	<h3>Your Reservations</h3>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Reservation Slot/Room</th>
	      <th>Reservation Details</th>
	      <th>Cancel Registration</th>
	    </tr>
	  </thead>
	  <tbody>
			@foreach ($your_reservations as $reservation)
	    <tr>
	    	<td style="width: 120px;"><b><a href="{{ route('check-date-for-reservation', [$reservation->reservation_slot]) }}">{{$reservation->reservation_slot->title}}</a></b></td>
	      <td>
	      	<p>{{$reservation->reservation_slot->description}}</p>
					@if ($reservation->for_event)
					<p>This reservation is attached to an <a href="{{route('show-event', [$reservation->event] )}}">event.</a></p>
					@endif
	      	<p>{{ date("l F j, Y", strtotime($reservation->start_time)) }} at {{ date("g:i A", strtotime($reservation->start_time)) }}<br/>
	      	Length: {{$reservation->duration()}} minutes</p>
	      </td>
	      <td style="width: 270px;">
					@if ($reservation->for_event)
						<a href="{{route('destroy-reservation', $reservation)}}" confirm="This reservation is attached to an event. Deleting this reservation will also delete the event and cancel all registrations." class="btn btn-danger pull-right">Cancel Reservation</a>
					@else
						<a href="{{route('destroy-reservation', $reservation)}}" confirm="Are you sure you want to DELETE this reservation?" class="btn btn-danger pull-right">Cancel Reservation</a>
					@endif
				</td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
@endif
</div>
@endsection