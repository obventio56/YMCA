@extends("layouts.app")

@section("content")
<div class="container">
	<h3>Events titled {{$name}}</h3>
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
</div>
@endsection