@extends("layouts.app")

@section("content")

@foreach ($reservation_slots_data as $reservation_slot_data)
	<h2>{{$reservation_slot_data["reservation_slot"]->title}}</h2>
	<p>{{$reservation_slot_data["reservation_slot"]->description}}</p>
	<hr/>
	<p>Please note that you can book a <b>minimum of {{$reservation_slot_data["min_time"]}}</b> and a <b>maximum of {{$reservation_slot_data["max_time"]}}</b> with {{$reservation_slot_data["reservation_slot"]->title}}.</p><br/>
	<table class="span12">
		<tr>
			@foreach ($reservation_slot_data["hours_of_operation"] as $day => $value)
				@if (!is_null($value->open))
					<th style="text-align: left;">{{ ucwords($day) }}</th>
				@endif
			@endforeach
		</tr>
		<tr>
			@foreach ($reservation_slot_data["hours_of_operation"] as $day => $value)
				@if (!is_null($value->open))
					<td>
						<p style="font-size: 10px;">
							{{$value->open}} - {{$value->close}}
						</p>
					</td>
				@endif
			@endforeach
		</tr>
	</table>
<br/><br/><br/><br/>

@endforeach
<h3>Please Choose A Date</h3>
<p>Start by choosing a date that you would like to create a reservation on.<br/>You can also enter a date in the following format:<br/>Month-Date-Year (xx-xx-xxxx)</p>

<form action="{{route('check-time-for-reservation', $reservation_slots_ids)}}" method="post" name="checkDateFrm" style="padding-bottom: 190px;">
	{{ csrf_field() }}
	<input type="text" id="reservation_datepicker" name="desired_date" class="datepicker"><br/>
	<input type="submit" class="btn" value="Check Availability On This Date"/>
</form>

@endsection

@section('javascript')
<script type="text/javascript"> 
	$(document).ready(function() {
		var today = new Date();
		$('#reservation_datepicker').datepicker({ "format": "mm-dd-yyyy", "weekStart": 0, "startDate": "#{Date.today}"});
	});
</script>
@endsection
