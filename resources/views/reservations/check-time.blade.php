@extends("layouts.app")


@section("content")
@if (Auth::user()->role == 2)
	<a href="{{route('calendar-of-reservations')}}" class="btn" style="margin-right: 9px;">Calendar Overview</a>
	<a href="{{route('reservation-slot-groups-index')}}" class="btn" style="margin-right: 9px;">Reservation Slot Groups</a>
	<br/><br/>
@endif
	@foreach($reservation_slot_time_slots as $time_slots)
	<h2>Here Are The Available Slots For {{$time_slots["reservation_slot"]->title}} on {{date('l, n/j/Y', $time_slots["date"])}}</h2>
		<p>Click on the desired start time of your reservation. We'll have you choose the duration of your reservation next.</p>
		<hr>
		<p>{{$time_slots["reservation_slot"]->title}} hours for this date are from {{$time_slots["hours"]->open}} until {{$time_slots["hours"]->close}}</p>
	<div style="width: 500px; border: 1px solid #bbb; border-bottom: none;">
			@foreach ($time_slots["complete_slots"] as $time_slot)
			@if ($time_slot[1] == "available")
			<a href="{{ route('new-reservation', [$time_slots["reservation_slot"], $time_slot[0]] ) }}"><div style="border-bottom: 1px dotted #ddd; background-color: #efefef; width: 100%; height: 40px;"><p style="padding: 10px;">{{ date("g:i A", $time_slot[0]) }}</p></div></a>
			@elseif  ($time_slot[1] == "taken")
			<div style="border-bottom: 1px dotted #ddd; background-color: #ffefef; width: 100%; height: 40px;"><p style="padding: 10px;">{{ date("g:i A", $time_slot[0]) }}</p></div>
			@endif
		@endforeach
	</div>   
	@endforeach
@endsection