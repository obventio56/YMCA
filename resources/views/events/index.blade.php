@extends("layouts.app")


@section("content")
<div class="container">
	<h3>Events</h3>
	<p>You'll find all events listed below.</p>
@if (Auth::user()->role == 2 || Auth::user()->role == 1)
  <a href="{{route('new-event')}}" class="btn btn-success" style="margin-right: 9px;">Create New Event</a>
	<br/><br/>
@endif
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Event</th>
	      <th>Description/Location</th>
	      <th>Manager Email</th>
	      <th>Actions</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach ($events as $event)
	    <tr>
	    	<td style="width: 120px;"><b><a href="{{route('show-event', $event)}}">{{$event->name}}</a></b></td>
	      <td><p>{{$event->description}}</p><p><i>{{$event->reservation->reservation_slot->title}}<br/>Date: {{date("l F j, Y", strtotime($event->reservation->start_time))}}
          <br/>Time: {{date("g:i A", strtotime($event->reservation->start_time))}} - {{date("g:i A", strtotime($event->reservation->end_time))}}</td>
	      <td>{{$event->notification_email}}</td>
        <td>
          <a href="{{route('destroy-event', $event)}}" confirm="Are you sure?" class="btn btn-danger pull-right">Delete Event</a><br/>
          <a href="{{route('edit-event', $event)}}"  style="margin-right: 9px;" class="btn btn-infro pull-right">Edit Event</a><br/>
        </td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
	<br/>
	<h3>Events You've Registered For</h3>
	<table class="table table-bordered table-striped">
	  <thead>
	    <tr>
	    	<th>Event</th>
	      <th>Description/Location</th>
	      <th>Cancel Registration</th>
	    </tr>
	  </thead>
	  <tbody>
			@foreach (Auth::user()->registrations as $registration)
	    <tr>
	    	<td style="width: 120px;"><b><a href="{{route('show-event', [$registration->event])}}">{{$registration->event->name}}</a></b></td>
	      <td><p>{{$registration->event->description}}</p><p><i>{{$registration->event->reservation->reservation_slot->title}}<br/>
					Date: {{date("l F j, Y", strtotime($registration->event->reservation->start_time))}}
          <br/>Time: {{date("g:i A", strtotime($registration->event->reservation->start_time))}} - {{date("g:i A", strtotime($registration->event->reservation->end_time))}}</td>
	      <td><a href="{{route('destroy-registration', [$registration])}}">Can't make it?<br/>Cancel Your Registration.</a></td>
	    </tr>
			@endforeach
	  </tbody>
	</table>
</div>
@endsection