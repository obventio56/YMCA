@extends("layouts.app")

@section("content")
  <h2>Reservations Monthly Overview</h2>
	@if (Auth::user()->role == 2)
		<a href="{{route('reservation-slots-index')}}" class="btn" style="margin-right: 9px;">All Reservations</a>
		<a href="{{route('reservation-slot-groups-index')}}" class="btn" style="margin-right: 9px;">Reservation Slot Groups</a>
		<br/><br/>
	@endif
	<div class="tiva-events-calendar full" data-source="json"></div>
@endsection

@section("javascript")
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/en.js') }}"></script> 
<script>
  events_json = {"items":[
	  @foreach($reservations as $reservation)
      {
						@if(isset($reservation->reservation_slot))
            "name": "{{$reservation->reservation_slot->title}}",
						@else
            "name": "{{$reservation->title}}",
						@endif
						"color":
						@if($reservation->for_event)
						"1",
						@elseif($reservation->public)
						"4",
						@else 
						"2",
						@endif
            "day":"{{ date('j', strtotime($reservation->start_time)) }}",
						"month":"{{ date('n', strtotime($reservation->start_time)) }}",
						"year":"{{ date('o', strtotime($reservation->start_time)) }}",
						"time":"{{ date('g:i A', strtotime($reservation->start_time)) }} - {{ date('g:i A', strtotime($reservation->end_time)) }}",
            "description": "{{ preg_replace( "/\r|\n/", "", $reservation->notes ) }}" +
						"<br><br>For more information please email <a href='mailto:{{$reservation->user->email}}'>{{$reservation->user->email}}<\/a>." + 
						"<br><br><a href='{{route("destroy-reservation", [$reservation])}}' class='btn btn-danger pull-left' data-confirm='Are you sure you want to DELETE this reservation?' rel='nofollow'>Cancel This Reservation<\/a>"
      },
    @endforeach
		]}
</script>
<script src="{{ asset('js/calendar.js') }}"></script> 
@endsection

@section("stylesheets")
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
  <link href="{{ asset('css/calendar_full.css') }}" rel="stylesheet">
  <link href="{{ asset('css/calendar_compact.css') }}" rel="stylesheet">
@endsection