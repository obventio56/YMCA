@extends("layouts.app")


@section("content")
<div class="container">
	<h3>Edit {{$reservation_slot->title}}</h3>
	<p>Enter the details for this reservation slot below.</p>
  
	<form id="create-reservation-slot" action="{{route('update-reservation-slot', [$reservation_slot])}}" class="well" method="POST">
		{{ csrf_field() }}
		
		<div class="container">
			<div class="span6">
        <label for="title">Name</label>
        <input value="{{ $reservation_slot->title }}" type="text" name="title"/><br/><br/>
        
        <label for="description">Description</label>
        <textarea name="description" col="60" rows="12">{{ $reservation_slot->description }}</textarea><br/><br/>
			
        <label for="primary_email">Primary Email Address</label>
        <input value="{{ $reservation_slot->primary_email }}" type="email" name="primary_email"/><br/><br/>
        
        <label for="notification_emails">Email Addresses for Notifications</label>
        <label for="notification_emails">(separate email addresses with a comma and don't use spaces)</label>
        <input value="{{ $reservation_slot->notification_emails }}" type="text" name="notification_emails"/><br/><br/>
				
				<label for="location_id">Location</label>
        <select name="location_id">
          <option value="">Select Location</option>
          @foreach ($locations as $location)
            <option value="{{$location->id}}" 
                    @if ($reservation_slot->location_id == $location->id)
                    selected="selected"
                    @endif 
                    >{{$location->title}}</option>
          @endforeach
        </select>
        
			</div>
			<div class="span5">
				<div class="container">
					<h4>Business Hours</h4>
		  		<div id="biz_hours">
						<label>Sunday</label>
						<input value="{{$hours_of_operation->sunday->open }}" type="text" class="timepicker" name="hours_of_operation[sunday][open]"/> - 
            <input type="text" class="timepicker" value="{{$hours_of_operation->sunday->close }}" name="hours_of_operation[sunday][close]"/>
						<label>Monday</label>
						<input value="{{$hours_of_operation->monday->open }}" type="text" class="timepicker" name="hours_of_operation[monday][open]"/> - 
            <input type="text" class="timepicker" value="{{$hours_of_operation->monday->close }}" name="hours_of_operation[monday][close]"/>
						<label>Tuesday</label>
						<input value="{{$hours_of_operation->tuesday->open }}" type="text" class="timepicker" name="hours_of_operation[tuesday][open]"/> - 
            <input type="text" class="timepicker" value="{{$hours_of_operation->tuesday->close }}" name="hours_of_operation[tuesday][close]"/>
						<label>Wedensday</label>
						<input value="{{$hours_of_operation->wednesday->open }}" type="text" class="timepicker" name="hours_of_operation[wednesday][open]"/> - 
            <input type="text" class="timepicker" value="{{$hours_of_operation->wednesday->close }}" name="hours_of_operation[wednesday][close]"/>
						<label>Thursday</label>
						<input value="{{$hours_of_operation->thursday->open }}" type="text" class="timepicker" name="hours_of_operation[thursday][open]"/> - 
            <input type="text" class="timepicker" value="{{$hours_of_operation->thursday->close }}" name="hours_of_operation[thursday][close]"/>
						<label>Friday</label>
						<input value="{{$hours_of_operation->friday->open }}" type="text" class="timepicker" name="hours_of_operation[friday][open]"/> - 
            <input type="text" class="timepicker" value="{{$hours_of_operation->friday->close }}" name="hours_of_operation[friday][close]"/>
						<label>Saturday</label>
						<input value="{{$hours_of_operation->saturday->open }}" type="text" class="timepicker" name="hours_of_operation[saturday][open]"/> - 
            <input type="text" class="timepicker" value="{{$hours_of_operation->saturday->close }}" name="hours_of_operation[saturday][close]"/>
		  		</div>
				</div><br/>
				<label>Individual Time Slot (in minutes)</label>
				<input value="{{$reservation_slot->time_interval}}" type="text" name="time_interval"><br/><br/>
				<label>Maximum Reservation Time (in minutes)</label>
				<input value="{{$reservation_slot->max_time}}" type="text" name="max_time"><br/><br/>
				<label>Advanced Reservation Window (in days)</label>
				<input value="{{$reservation_slot->reservation_window}}" type="text" name="reservation_window"><br/><br/>
				<label>Is this reservation slot public?</label>
				<input type="checkbox" name="public"
							 @if ($reservation_slot->public)
								checked
							 @endif
							 /><br/><br/>
				<label>Groups</label>
				<select name="groups[]" multiple>
					@foreach ($reservation_slot_groups as $reservation_slot_group)
						<option value="{{$reservation_slot_group->id}}"
										@if ($reservation_slot->has_reservation_slot_group($reservation_slot_group))
											selected
										@endif
										>{{$reservation_slot_group->title}}</option>
					@endforeach
				</select><br/><br/>
				<label>Reservation Slot Notes & Facility Requirements</label>
				<textarea col="60" rows="12" name="notes">{{$reservation_slot->notes}}</textarea><br/><br/>
			</div>
			<div class="span12">
				<br/><br/><input class="btn btn-success" type="submit" value="Update Reservation Slot"/>
			</div>
		</div>	  
  </form>
</div>
@endsection
