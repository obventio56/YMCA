@extends("layouts.app")

@section("content")
<h2>{{$reservation_slot->title}}</h2>
<p>{{$reservation_slot->description}}</p>
<hr/>
<p>Please note that you can book a <b>minimum of {{$reservation_slot->time_interval}} minutes</b> and a <b>maximum of {{$reservation_slot->max_time}} minutes</b> with {{$reservation_slot->title}}.</p><br/>
<table class="span12">
	<tr>
		<th style="text-align: left;">Monday</th>
		<th style="text-align: left;">Tuesday</th>
		<th style="text-align: left;">Wednesday</th>
		<th style="text-align: left;">Thursday</th>
		<th style="text-align: left;">Friday</th>
		<th style="text-align: left;">Saturday</th>
		<th style="text-align: left;">Sunday</th>
	</tr>
	<tr>
		<td><p style="font-size: 10px;">{{$hours_of_operation->monday->open}} - {{$hours_of_operation->monday->close}}</p></td>
		<td><p style="font-size: 10px;">{{$hours_of_operation->tuesday->open}} - {{$hours_of_operation->tuesday->close}}</p></td>
		<td><p style="font-size: 10px;">{{$hours_of_operation->wednesday->open}} - {{$hours_of_operation->wednesday->close}}</p></td>
		<td><p style="font-size: 10px;">{{$hours_of_operation->thursday->open}} - {{$hours_of_operation->thursday->close}}</p></td>
		<td><p style="font-size: 10px;">{{$hours_of_operation->friday->open}} - {{$hours_of_operation->friday->close}}</p></td>
		<td><p style="font-size: 10px;">{{$hours_of_operation->saturday->open}} - {{$hours_of_operation->saturday->close}}</p></td>
		<td><p style="font-size: 10px;">{{$hours_of_operation->sunday->open}} - {{$hours_of_operation->sunday->close}}</p></td>
	</tr>
</table>
<br/><br/><br/><br/>
<h3>Please Choose A Date</h3>
<p>Start by choosing a date that you would like to create a reservation on.<br/>You can also enter a date in the following format:<br/>Month-Date-Year (xx-xx-xxxx)</p>

<form action="{{route('check-time-for-reservation', $reservation_slot)}}" method="post" name="checkDateFrm" style="padding-bottom: 190px;">
	{{ csrf_field() }}
	<input type="text" id="reservation_datepicker" name="desired_date" class="datepicker"><br/>
	<input type="submit" class="btn" value="Check Availability On This Date"/>
</form>

@endsection

@section('javascript')
<script type="text/javascript"> 
	$(document).ready(function() {
		var today = new Date();
		var maxdate = new Date(today.getFullYear(), today.getMonth(), today.getDate()+{{$reservation_slot->reservation_window}});
		$('#reservation_datepicker').datepicker({ "format": "mm-dd-yyyy", "weekStart": 0, "startDate": "#{Date.today}", "endDate": maxdate, "maxDate": maxdate  });
	});
</script>
@endsection
