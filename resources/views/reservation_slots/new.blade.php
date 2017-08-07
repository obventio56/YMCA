@extends("layouts.app")


@section("content")
<div class="container">
	<h3>Create A New Resource for Reservation</h3>
	<p>Enter the details for this resource below.</p>
  
	<form id="create-reservation-slot" action="{{route('create-reservation-slot')}}" class="well" method="POST">
		{{ csrf_field() }}
		
		<div class="container">
			<div class="span6">
        <label for="title">Name</label>
        <input value="{{ old('title') }}" type="text" name="title"/><br/><br/>
        
        <label for="description">Description</label>
        <textarea name="description" col="60" rows="12">{{ old('description') }}</textarea><br/><br/>
			
        <label for="primary_email">Primary Email Address</label>
        <input value="{{ old('primary_email') }}" type="email" name="primary_email"/><br/><br/>
        
        <label for="notification_emails">Email Addresses for Notifications</label>
        <label for="notification_emails">(separate email addresses with a comma and don't use spaces)</label>
        <input value="{{ old('notification_emails') }}" type="text" name="notification_emails"/><br/><br/>
				
				<label for="location_id">Email Addresses for Notifications</label>
        <select name="location_id">
          <option value="">Select Location</option>
          @foreach ($locations as $location)
            <option value="{{$location->id}}">{{$location->title}}</option>
          @endforeach
        </select>
        
			</div>
			<div class="span5">
				<div class="container">
					<h4>Business Hours</h4>
		  		<div id="biz_hours">
						<label>Sunday</label>
						<input value="{{ old('hours_of_operation[sunday][open]') }}" type="text" class="timepicker" name="hours_of_operation[sunday][open]"/> - <input type="text" class="timepicker" value="{{ old('hours_of_operation[sunday][close]') }}" name="hours_of_operation[sunday][close]"/>
						<label>Monday</label>
						<input value="{{ old('hours_of_operation[monday][open]') }}" type="text" class="timepicker" name="hours_of_operation[monday][open]"/> - <input type="text" class="timepicker" value="{{ old('hours_of_operation[monday][close]') }}" name="hours_of_operation[monday][close]"/>
						<label>Tuesday</label>
						<input value="{{ old('hours_of_operation[tuesday][open]') }}" type="text" class="timepicker" name="hours_of_operation[tuesday][open]"/> - <input type="text" class="timepicker" value="{{ old('hours_of_operation[tuesday][close]') }}" name="hours_of_operation[tuesday][close]"/>
						<label>Wedensday</label>
						<input value="{{ old('hours_of_operation[wednesday][open]') }}" type="text" class="timepicker" name="hours_of_operation[wednesday][open]"/> - <input type="text" class="timepicker" value="{{ old('hours_of_operation[wednesday][close]') }}" name="hours_of_operation[wednesday][close]"/>
						<label>Thursday</label>
						<input value="{{ old('hours_of_operation[thrusday][open]') }}" type="text" class="timepicker" name="hours_of_operation[thursday][open]"/> - <input type="text" class="timepicker" value="{{ old('hours_of_operation[thursday][close]') }}" name="hours_of_operation[thursday][close]"/>
						<label>Friday</label>
						<input value="{{ old('hours_of_operation[friday][open]') }}" type="text" class="timepicker" name="hours_of_operation[friday][open]"/> - <input type="text" class="timepicker" value="{{ old('hours_of_operation[friday][close]') }}" name="hours_of_operation[friday][close]"/>
						<label>Saturday</label>
						<input value="{{ old('hours_of_operation[saturday][open]') }}" type="text" class="timepicker" name="hours_of_operation[saturday][open]"/> - <input type="text" class="timepicker" value="{{ old('hours_of_operation[saturday][close]') }}" name="hours_of_operation[saturday][close]"/>
		  		</div>
				</div><br/>
				<label>Individual Time Slot (in minutes)</label>
				<input value="{{ old('time_interval') }}" type="text" name="time_interval"><br/><br/>
				<label>Maximum Reservation Time (in minutes)</label>
				<input value="{{ old('max_time') }}" type="text" name="max_time"><br/><br/>
				<label>Advanced Reservation Window (in days)</label>
				<input value="{{ old('reservation_window') }}" type="text" name="reservation_window"><br/><br/>
				<label>Groups</label>
				<select name="groups[]" multiple>
					@foreach ($reservation_slot_groups as $reservation_slot_group)
						<option value="{{$reservation_slot_group->id}}">{{$reservation_slot_group->title}}</option>
					@endforeach
				</select><br/><br/>
				<label>Resource Notes & Facility Requirements</label>
				<textarea col="60" rows="12" name="notes">{{ old('notes') }}</textarea><br/><br/>
			</div>
			<div class="span12">
				<br/><br/><input class="btn btn-success" type="submit" value="Create New Resource"/>
			</div>
		</div>	  
  </form>
</div>
@endsection
