@extends("layouts.app")

@section("content")
<div class="container">
	<div class="container">
			<div class="span12">
				<h3>{{$event->name}}
          @if (!is_null($event->fee))
             - {{$event->fee}}
          @endif
        </h3>
				<h4 style="color: #999;"><i>{{$event->reservation->reservation_slot->title}}</i></h4><br/>
				<h4>{{date("l F j, Y", strtotime($event->reservation->start_time))}} <br> {{date("g:i A", strtotime($event->reservation->start_time))}} - {{date("g:i A", strtotime($event->reservation->end_time))}}</h4><br/>
				<p>{{$event->description}}</p><br/>
				
				<p>For more information please email <a href="mailto:{{$event->user->email}}">{{$event->user->name}}</a>.</p><br/><br/>
				
				<div class="well">
				@if (Auth::user()->registered($event))
					<p>You're registered for this event!</p>
					<a href="{{ route('events-index') }}" class="btn">View Your Events To Manage This Registration</a>
				@elseif ($event->full())
					<p>We're sorry, but this class already is full. You are welcome to stop by in case someone does not show up, but we cannot guarantee you will have a spot.</p>
				@elseif (!$event->open_to_register())
					<p>This event is open for up to {{$event->remaining_spots() }} more participants, but registration is only available within {{$event->registration_window}} days of the event. Please return then to register.</p>
				@else
					<p>This event is open for up to {{$event->remaining_spots() }} more participants</p>
					<a href="{{route('create-registration', [$event])}}" class="btn">Register Now For This Event</a>
				@endif
				</div>
				
				
				@if (Auth::user()->role == 2 || Auth::user()->role == 1)
				<br/><br/><hr/><br/>
				<h3>Event Administration</h3>
				<br/><br/>
				<div class="well">
				<p>Copy and paste the following link anywhere you need to allow registration for this event:<br/>
				<span style="color: #ff0000;">{{route('show-event', $event)}}</span>
				
				<p>To allow reservations to any event with this name (good for recurring events of the same name):<br/>
				<span style="color: #ff0000;">{{route('events-by-name', $event->name)}}</span>
				</p></div>
				<br/>
				
				
					<br/><h3>Registered Users</h3>
					<table class="table table-striped">
		        <thead>
		          <tr>
		            <th>Name</th>
		            <th>Email</th>
		          </tr>
		        </thead>
		        <tbody>
		       	
					@foreach ($event->registrations as $registration)
		      
		          <tr>
		            <td>{{$registration->user->name}}</td>
		            <td>{{$registration->user->name}}</td>
		            <td><a href="{{route('destroy-registration', $registration)}}">Cancel Registration</a></td>
		          </tr>
					@endforeach
		      </tbody>
		      </table><br/><br/>
				@endif
			</div>
		</div>	  

</div>
@endsection
