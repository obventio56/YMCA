@extends("layouts.app")


@section("content")

		<a href="javascript:window.print()">Print</a>
			<h2>Here Are The Available Slots For {{$reservation_slot->title}} on {{date('l, n/j/Y', $date)}}</h2>
	<p>Click on the desired start time of your reservation. We'll have you choose the duration of your reservation next.</p>
	<hr>
	<p>{{$reservation_slot->title}} hours for this date are from {{$hours->open}} until {{$hours->close}}</p>
	<div style="width: 500px; border: 1px solid #bbb; border-bottom: none;">
		@foreach ($complete_slots as $time_slot)
			@if ($time_slot[1] == "available")
			<a href="{{ route('new-reservation', [$reservation_slot, $time_slot[0]] ) }}"><div style="border-bottom: 1px dotted #ddd; background-color: #efefef; width: 100%; height: 40px;"><p style="padding: 10px;">{{ date("g:i A", $time_slot[0]) }}</p></div></a>
			@elseif  ($time_slot[1] == "taken")
			<div style="border-bottom: 1px dotted #ddd; background-color: #ffefef; width: 100%; height: 40px;"><p style="padding: 10px;">{{ date("g:i A", $time_slot[0]) }}</p></div>
			@endif
		@endforeach
	</div>     
@endsection